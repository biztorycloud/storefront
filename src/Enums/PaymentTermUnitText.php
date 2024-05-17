<?php

namespace Biztory\Storefront\Enums;

enum PaymentTermUnitText: string
{
    case Today = 'today';
    case EndOfMonth = 'end of month';
    case NextMonth = 'next month';
    case Days = 'days';
    case Weeks = 'weeks';
    case Months = 'months';
}
