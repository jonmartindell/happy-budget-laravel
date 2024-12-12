<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'heading', 'sort', 'budget', 'infrequent', 'expense'];

    // Relationships
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // Instance method to calculate YTD spent (Year-To-Date spent)
    public function ytdSpent($month)
    {
        $cutoffDate = \Carbon\Carbon::parse($month)->startOfMonth();
        return $this->transactions()
            ->where('date', '<', $cutoffDate)
            ->sum('amount');
    }

    // Instance method to calculate spent in a specific month
    public function spent($month)
    {
        $startDate = \Carbon\Carbon::parse($month)->startOfMonth();
        $endDate = \Carbon\Carbon::parse($month)->endOfMonth();
        return $this->transactions()
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('amount');
    }

    // Instance method to calculate remaining budget
    public function remaining($month)
    {
        return $this->budgetToEom($month) - $this->spent($month) - $this->ytdSpent($month);
    }

    // Budget calculations for the start of the month (SOM) and end of the month (EOM)
    public function budgetToSom($month)
    {
        $monthNum = \Carbon\Carbon::parse($month)->format('n') - 1; // 1-based month index
        return $this->budget * $monthNum;
    }

    public function budgetToEom($month)
    {
        $monthNum = \Carbon\Carbon::parse($month)->format('n'); // 1-based month index
        return $this->budget * $monthNum;
    }

    // Total spent till the end of the month
    public function spentToEom($month)
    {
        return $this->spent($month) + $this->ytdSpent($month);
    }

    // Remaining budget for the year
    public function remainingForYear($month)
    {
        return $this->budget * 12 - $this->spentToEom($month);
    }

    // Percentage of the remaining budget for the year
    public function yearlyPercentRemaining($month)
    {
        if ($this->budget <= 0) {
            return 'na';
        }
        return (int) (($this->remainingForYear($month) / ($this->budget * 12)) * 100);
    }

    // Status of the category based on spending
    public function status($month)
    {
        if ($this->infrequent) {
            $yearlyMax = $this->budget * 12;
            if ($this->spentToEom($month) >= $yearlyMax) {
                return 'danger';
            }

            $percentageYearlySpent = $this->spentToEom($month) / $yearlyMax;
            $percentageOfYear = \Carbon\Carbon::parse($month)->endOfMonth()->dayOfYear / 365.0;

            if ($percentageYearlySpent >= 0.40 && $percentageOfYear <= 0.10) return 'warning';
            if ($percentageYearlySpent >= 0.50 && $percentageOfYear <= 0.20) return 'warning';
            if ($percentageYearlySpent >= 0.60 && $percentageOfYear <= 0.30) return 'warning';
            if ($percentageYearlySpent >= 0.70 && $percentageOfYear <= 0.40) return 'warning';
            if ($percentageYearlySpent >= 0.80 && $percentageOfYear <= 0.60) return 'warning';
            if ($percentageYearlySpent >= 0.90 && $percentageOfYear <= 0.90) return 'warning';

            return 'success';
        }

        // For categories with frequent transactions
        if ($this->spentToEom($month) > $this->budgetToEom($month)) {
            return 'danger';
        }

        $percentageOfYtdSpent = $month === "January" ? 0.0 : $this->ytdSpent($month) / $this->budgetToSom($month);
        $percentageOfMonthSpent = $this->spent($month) / $this->budget;

        if ($percentageOfYtdSpent >= 0.90 && $percentageOfMonthSpent >= 0.90) {
            return 'warning';
        }

        return 'success';
    }

    // Reason for the status of the category
    public function statusReason($month)
    {
        if ($this->infrequent) {
            $yearlyMax = $this->budget * 12;
            if ($this->spentToEom($month) >= $yearlyMax) {
                return "Exceeded budget for year";
            }

            $percentageYearlySpent = $this->spentToEom($month) / $yearlyMax;
            $percentageOfYear = \Carbon\Carbon::parse($month)->endOfMonth()->dayOfYear / 365.0;

            if ($percentageYearlySpent >= 0.40 && $percentageOfYear <= 0.10) return "Spending yearly amount too quickly in year";
            if ($percentageYearlySpent >= 0.50 && $percentageOfYear <= 0.20) return "Spending yearly amount too quickly in year";
            if ($percentageYearlySpent >= 0.60 && $percentageOfYear <= 0.30) return "Spending yearly amount too quickly in year";
            if ($percentageYearlySpent >= 0.70 && $percentageOfYear <= 0.40) return "Spending yearly amount too quickly in year";
            if ($percentageYearlySpent >= 0.80 && $percentageOfYear <= 0.60) return "Spending yearly amount too quickly in year";
            if ($percentageYearlySpent >= 0.90 && $percentageOfYear <= 0.90) return "Spending yearly amount too quickly in year";

            return "";
        }

        if ($this->spentToEom($month) > $this->budgetToEom($month)) {
            return "Exceeded budget for {$month}";
        }

        $percentageOfYtdSpent = $month === "January" ? 0.0 : $this->ytdSpent($month) / $this->budgetToSom($month);
        $percentageOfMonthSpent = $this->spent($month) / $this->budget;

        if ($percentageOfYtdSpent >= 0.90 && $percentageOfMonthSpent >= 0.90) {
            return "Getting too close to exceeding YTD budget";
        }

        return "";
    }
}
