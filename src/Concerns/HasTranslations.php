<?php
namespace Lnq\Blog\Concerns;

trait HasTranslations
{
    /** @var string[] */
    protected array $translatable = [];

    protected function getLocale(): string
    {
        return app()->getLocale() ?? 'es';
    }

    protected function fromJsonLocale(?array $data): ?string
    {
        if (!is_array($data)) return $data;
        $loc = $this->getLocale();
        return $data[$loc] ?? $data['es'] ?? reset($data) ?: null;
    }

    protected function toJsonLocale(string $attr, string|array|null $value): ?array
    {
        if ($value === null) return null;
        if (is_array($value)) return $value; // ya viene completo {es:, en:, ...}
        $loc = $this->getLocale();
        $current = (array) ($this->attributes[$attr] ?? []);
        $decoded = is_string($current) ? json_decode($current, true) ?: [] : $current;
        $decoded[$loc] = $value;
        return $decoded;
    }
}
