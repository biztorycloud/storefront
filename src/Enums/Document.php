<?php

namespace Biztory\Storefront\Enums;

enum Document: string
{
    case SaleOrder = 'SaleOrder';
    case Invoice = 'Invoice';
    case Quote = 'Quote';
}
