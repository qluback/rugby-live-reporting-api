<?php

namespace App\Enum;

enum HighlightType: string
{
    case TRY = 'try';
    case CONVERTED_TRY = 'convertedTry';
    case PENALTY_TRY = 'penaltyTry';
    case PENALTY = 'penalty';
    case DROP_GOAL = 'dropGoal';
}
