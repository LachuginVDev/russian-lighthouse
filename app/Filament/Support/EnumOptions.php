<?php

namespace App\Filament\Support;

use BackedEnum;
use Illuminate\Support\Collection;

final class EnumOptions
{
    /**
     * @param  class-string<BackedEnum>  $enum
     * @return array<string, string>
     */
    public static function from(string $enum): array
    {
        /** @var Collection<int, BackedEnum> $cases */
        $cases = collect($enum::cases());

        return $cases
            ->mapWithKeys(fn (BackedEnum $case): array => [
                $case->value => method_exists($case, 'label') ? $case->label() : $case->name,
            ])
            ->all();
    }
}
