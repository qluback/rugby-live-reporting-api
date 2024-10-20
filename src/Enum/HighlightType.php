<?php

namespace App\Enum;

enum HighlightType: string
{
    case TRY = 'try';
    case CONVERTED_TRY = 'convertedTry';
    case PENALTY_TRY = 'penaltyTry';
    case PENALTY = 'penalty';
    case DROP_GOAL = 'dropGoal';

    public function getPoints()
    {
        return match ($this) {
            HighlightType::TRY => 5,
            HighlightType::CONVERTED_TRY, HighlightType::PENALTY_TRY => 7,
            HighlightType::PENALTY, HighlightType::DROP_GOAL => 3,
        };
    }
}
