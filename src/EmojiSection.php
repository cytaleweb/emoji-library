<?php
namespace iksaku\Emoji;

/**
 * Class EmojiSection
 * @package iksaku\Emoji
 */
abstract class EmojiSection {
    public function getByName(string $name) {
        $name = "static::" . strtoupper(str_replace("-", "_", $name));
        if (!defined($name)) throw new \Exception("Unknown Emoji");
        return constant($name);
    }
}