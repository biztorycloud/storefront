<?php

namespace Biztory\Storefront\Enums;

enum DocumentType: string
{
    case SaleOrder = 'SaleOrder';
    case Invoice = 'Invoice';
    case Quote = 'Quote';
}
