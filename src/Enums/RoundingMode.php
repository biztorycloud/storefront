<?php

namespace Biztory\Storefront\Enums;

enum RoundingMode: int
{
    case Off = 0;
    /**
     * 0.01 ~ 0.04 = 0.00
     * 0.05 ~ 0.09 = 0.10
     */
    case NoFiveCents = 1;
    /**
     * 0.01 ~ 0.02 = 0.00
     * 0.03 ~ 0.07 = 0.05
     * 0.08 ~ 0.09 = 0.10
     */
    case WithFiveCents = 2;
}
