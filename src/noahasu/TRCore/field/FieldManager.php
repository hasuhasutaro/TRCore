<?php
namespace noahasu\TRCore\field;

final class FieldManager {
    /** @var Field[] */
    private array $fields = [];

    private static $instance = null;

    private function __construct() {
        // Initialize fields here if needed
    }

    public static function getInstance(): self {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function addField(Field $field): void {
        $this->fields[$field->getId()] = $field;
    }

    public function getFieldById(int $id): ?Field {
        return $this->fields[$id] ?? null;
    }

    public function hasField(int $id): bool {
        return isset($this->fields[$id]);
    }

    public function getAllFields(): array {
        return $this->fields;
    }
}