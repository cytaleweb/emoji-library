<?php
namespace iksaku\Emoji;

class SkinTone {
    const LIGHT = "\u{1F3FB}";
    const MEDIUM_LIGHT = "\u{1F3FC}";
    const MEDIUM = "\u{1F3FD}";
    const MEDIUM_DARK = "\u{1F3FE}";
    const DARK = "\u{1F3FF}";

    /**
     * WARNING: If you pass a sequence of emojis in a single string,
     *  this function will change all skin tones of those emojis.
     *
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
     *  emoji's codepoint and the gender modifier (if there is going to be a gender modifier).
     *
     * First of all, we check if there is a skin tone modifier already assigned, if so, we will replace it with
     *  the newly requested skin tone.
     * If there is no skin tone modifier assigned already, we will look into gender modifier.
     *  If there is a gender modifier assigned, we will place the skin tone modifier between the actual emoji
     *  and the gender modifier.
     * If there are neither skin tone nor gender modifiers, we just place the requested skin tone modifier
     *  right after the emoji.
     *
     * Finally, we return the merged sequence of modifiers with the emoji.
     *
     * @param string $skinTone
     * @param string $emoji
     * @return string
     */
    public static function apply(string $skinTone, string $emoji) : string
    {
        foreach ([self::LIGHT, self::MEDIUM_LIGHT, self::MEDIUM, self::MEDIUM_DARK, self::DARK] as $pSkinTone) {
            if (stripos($emoji, $pSkinTone)){
                $emoji = str_replace($pSkinTone, $skinTone, $emoji);
                break;
            }
        }

        foreach ([Gender::MALE, Gender::FEMALE] as $gender){
            if (stripos($emoji, $gender)) {
                $emoji = str_replace($gender, $skinTone . $gender, $emoji);
                break;
            }
        }

        return $emoji . $skinTone;
    }
}