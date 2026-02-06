<?php

namespace App\AI\Tool;

use Symfony\AI\Agent\Toolbox\Attribute\AsTool;
use Symfony\AI\Platform\Contract\JsonSchema\Attribute\With;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;

#[Autoconfigure(tags: ['ai.tool'])]
#[AsTool(
    name: 'set_discount',
    description: 'Sets a discount percentage for a product or order.'
)]
final readonly class DiscountTool
{
    public function __invoke(
        #[With(minimum: 0, maximum: 50)]
        int $percentage
    ): string {
        return sprintf("Discount set to %d%%.", $percentage);
    }
}
