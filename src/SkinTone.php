<?php
namespace iksaku\Emoji;

class SkinTone {
    const LIGHT = "\u{1F3FB}";
    const MEDIUM_LIGHT = "\u{1F3FC}";
    const MEDIUM = "\u{1F3FD}";
    const MEDIUM_DARK = "\u{1F3FE}";
    const DARK = "\u{1F3FF}";

    /**
     * NOTE: Be sure to only apply it to emojis that support skin tone modifiers,
     *  otherwise, unicode characters may break.
     *
     * How do this function applies the Skin Tone to the Emoji?
     *  We treat unicode characters as strings, split them and insert the skin tone modifier
     *  to get the emoji with the (correctly) applied skin tone.
     *
     * In order to use unicode characters as strings (since PHP7 no longer treats them as strings),
     * so firstly we encode both emoji and skin tone modifier into JSON string.
     *
     * After that, we are going to split JSON unicode parts into a PHP array.
     *  NOTE2: JSON codes are not the same as standard unicode ones...
     *
     * Next, we will insert the skin tone in the correct position of the array.
     *
     * Finally, we merge the string back to JSON string format and decode back to PHP string,
     *  so we can output it as an emoji with a correctly applied skin tone.
     *
     * @param string $skinTone
     * @param string $emoji
     * @return string
     */
    public static function applyTo(string $skinTone, string $emoji){
        $emoji = explode("\\", str_replace("\"", "", json_encode($emoji)));
        $skinTone = explode("\\", str_replace("\"", "", json_encode($skinTone)));
        array_shift($skinTone); // Remove Empty string form array start

        array_splice($emoji, 3, 0, $skinTone);

        return json_decode("\"" . implode("\\", $emoji) . "\"", true);
    }
}