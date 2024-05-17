<?php

namespace Biztory\Storefront\Enums;

enum ApprovalStatus: int
{
    case NotInUse = 0;
    case Active = 1;
    case Cancelled = 2;
    case Draft = 3;
    case Pending = 4;
    case Rejected = 5;
}
