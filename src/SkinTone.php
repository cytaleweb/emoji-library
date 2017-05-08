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
     * How does this function correctly applies the Skin Tone to the Emoji?
     *  Every emoji is represented with a unique codepoint, but you can also add extra codepoints to
     *  define a gender or skin tone.
     *
     * With that in mind, we must know first if the emoji is part of the unisex types (no gender assigned)
     *  or if there is a gender modifier present.
     * Skin tone must be defined before the gender is, so we must place the skin tone modifier between
     *  emoji's codepoint and the gender modifier.
     *
     * First, and if there is a gender modifier assigned, we split the emoji and the gender in two different variables.
     *  Otherwise, we just skip this step.
     * Next, we merge the skin tone modifier with the emoji codepoint, and, if there was a
     *  gender modifier assigned originally, we merge the gender modifier into the codepoint sequence.
     * Finally, we return the merged codepoints.
     *
     * @param string $skinTone
     * @param string $emoji
     * @return string
     */
    public static function apply(string $skinTone, string $emoji) : string
    {
        $gender = "";
        foreach ([Gender::MALE, Gender::FEMALE] as $g){
            if (!stripos($emoji, $g)) continue;

            $gender = $g;
            $emoji = str_replace($g, "", $emoji);
            break;
        }

        return $emoji . $skinTone . $gender;
    }
}