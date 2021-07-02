<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self BI() // Product Issues
 * @method static self BC() // Bill of Materials Cost Roll-Up
 * @method static self BR() // Product Receipts
 * @method static self BZ() // Negative Quantity Adjustment(from Bill of Materials)
 * @method static self IA() // Item Adjustment
 * @method static self II() // Item Issued
 * @method static self IC() // Standard Cost Adjustment
 * @method static self IN() // Negative Tier Adjustment
 * @method static self IP() // Physical Count
 * @method static self IR() // Item Received
 * @method static self IS() // Item Sold
 * @method static self IT() // Item Transfer
 * @method static self IX() // Purged Transactions
 * @method static self IZ() // Cost Tier Adjustment
 * @method static self JI() // Material Issue from Production Management
 * @method static self JR() // Finished Good Received from Production Management
 * @method static self PM() // Material Requisition
 * @method static self PO() // Purchase Order Item
 * @method static self PS() // Point of Sale Transactions
 * @method static self PZ() // Negative Quantity Adjustment(from Purchase Order)
 * @method static self SI() // Sales Order Issues
 * @method static self SO() // Sales Order Item
 * @method static self SZ() // Negative Quantity Adjustment(from Sales Order)
 * @method static self WC() // Work Order Cost Roll-Up
 * @method static self WI() // Work Order Issues
 * @method static self WR() // Work Order Receipts
 * @method static self WZ() // Negative Quantity Adjustment(from Work Order)
 **/

class InventoryTransactionTypeEnum extends Enum
{
    public static function toLabels() : array
    {
        return [
            'IR' => 'ITEM RECEIVED',
            'IS' => 'ITEM SOLD',
        ];
    }
}
