<?php

namespace App\AI\Tool;

use App\Enum\OrderRegion;
use Symfony\AI\Agent\Toolbox\Attribute\AsTool;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;

#[Autoconfigure(tags: ['ai.tool'])]
#[AsTool(
    name: 'get_order_status',
    description: 'Retrieves the current status of a customer order.'
)]
final readonly class OrderStatusTool
{
    public function __invoke(
        string $orderId,
        OrderRegion $region,
    ): string {
        return sprintf(
            "Order %s in region %s is currently: SHIPPED",
            $orderId,
            $region->value
        );
    }
}
