<?php

namespace App\Services;

class ProfanityFilter
{
    private $profanityWords = [
        // English profanity
        'asshole', 'bitch', 'bastard', 'damn', 'shit', 'fuck', 'fucking', 'cunt', 'dick',
        'pussy', 'whore', 'slut', 'faggot', 'nigger', 'retard', 'gay', 'stupid', 'idiot',
        'moron', 'dumb', 'kill yourself', 'kys', 'suicide', 'die', 'death', 'murder',
        'rape', 'sex', 'porn', 'xxx', 'naked', 'nude', 'breast', 'boobs', 'penis',
        'vagina', 'cocaine', 'drugs', 'weed', 'marijuana', 'alcohol', 'beer', 'wine',
        
        // Hindi/Urdu profanity (Hinglish spellings)
        'madarchod', 'bhenchod', 'chutiya', 'randi', 'bhosdi', 'gandu', 'lawda', 'lund',
        'chut', 'gaand', 'bhosdike', 'randike', 'chutiye', 'madarchod', 'benchod',
        'bakchod', 'harami', 'kamina', 'kutta', 'kutti', 'saala', 'saali', 'raand',
        'dalle', 'chakka', 'hijra', 'bsdk', 'mc', 'bc', 'chutmarike', 'maa ki chut',
        'behen ki chut', 'teri maa', 'bhag', 'nikal', 'mar ja', 'suicide kar',
        
        // Common variations and leetspeak
        'f*ck', 'f**k', 'sh*t', 'b*tch', 'a$$hole', 'd*mn', 'f0ck', 'sh1t',
        'b1tch', 'fuk', 'fack', 'shyt', 'byatch', 'azz', 'a$$', 'fukk',
        'phuck', 'phuk', 'shiit', 'sh!t', 'f!ck', 'b!tch', 'a$$h0le',
        
        // Other languages common abuses
        'puta', 'hijo', 'mierda', 'joder', 'cabrón', 'pendejo', 'culero',
        'pinche', 'chinga', 'verga', 'coño', 'marica', 'bollocks', 'wanker',
        'tosser', 'pillock', 'twat', 'prick', 'arse', 'arsehole', 'bloody',
        'blimey', 'bugger', 'sod', 'git', 'nutter', 'minger', 'munter',
        
        // Cyber bullying terms
        'kill urself', 'hang yourself', 'jump off', 'cut yourself', 'self harm',
        'worthless', 'useless', 'loser', 'pathetic', 'disgusting', 'ugly',
        'fat', 'skinny', 'anorexic', 'bulimic', 'freak', 'weird', 'creep',
        'stalker', 'pervert', 'sicko', 'psycho', 'crazy', 'mental', 'insane',
        
        // Hate speech
        'terrorist', 'bomber', 'killer', 'murderer', 'rapist', 'pedophile',
        'child molester', 'nazi', 'hitler', 'fascist', 'communist', 'jihadi',
        'extremist', 'radical', 'fanatic', 'cult', 'brainwashed', 'slave',
        
        // Adult content
        'masturbate', 'orgasm', 'cum', 'ejaculate', 'erection', 'horny',
        'aroused', 'kinky', 'fetish', 'bdsm', 'oral', 'anal', 'threesome',
        'gangbang', 'bukkake', 'dildo', 'vibrator', 'condom', 'viagra',
        
        // Drug related
        'heroin', 'ecstasy', 'mdma', 'lsd', 'crack', 'meth', 'crystal',
        'cannabis', 'ganja', 'hash', 'opium', 'morphine', 'codeine',
        'xanax', 'valium', 'rohypnol', 'ghb', 'ketamine', 'pcp',
        
        // Gambling
        'casino', 'betting', 'poker', 'blackjack', 'roulette', 'slot machine',
        'jackpot', 'lottery', 'scratch card', 'bingo', 'horse racing',
        
        // Scam terms
        'scam', 'fraud', 'cheat', 'steal', 'rob', 'theft', 'burglary',
        'embezzlement', 'money laundering', 'ponzi', 'pyramid scheme',
        'fake', 'counterfeit', 'phishing', 'spam', 'virus', 'malware',
        
        // Numbers and symbols that could be profanity
        '69', '420', '666', '88', '14', 'kek', 'pepe', 'chad', 'simp',
        'cuck', 'snowflake', 'karen', 'boomer', 'zoomer', 'millenial',
        
        // Romanized Hindi abuses
        'behen', 'behan', 'maa', 'baap', 'papa', 'mama', 'chacha', 'mausi',
        'nana', 'nani', 'dada', 'dadi', 'amma', 'abbu', 'ammi', 'walid',
        
        // Common variations in different scripts (transliterated)
        'maadarchod', 'madarchod', 'madharchod', 'madarchod', 'bhanchod',
        'bhaanchod', 'bhenchod', 'benchod', 'chutiyaa', 'chutiyaaa',
        'randii', 'randiii', 'ganndu', 'gannduu', 'lawdaa', 'lawdaaa'
    ];

    private $contextualProfanity = [
        // Phrases that might be abusive in context
        'your mother', 'your mom', 'your sister', 'your family', 'your wife',
        'your daughter', 'your son', 'your father', 'your dad', 'you suck',
        'you are', 'you look', 'i hate you', 'hate you', 'kill you',
        'murder you', 'rape you', 'beat you', 'slap you', 'punch you',
        'kick you', 'hurt you', 'harm you', 'damage you', 'destroy you',
        'teri maa', 'teri behen', 'teri biwi', 'teri family', 'tujhe maar',
        'tujhe maarunga', 'tere ko', 'tera baap', 'teri ammi', 'teri abbu'
    ];

    public function containsProfanity($text)
    {
        $text = strtolower($text);
        $text = $this->normalizeText($text);

        // Check for direct profanity matches
        foreach ($this->profanityWords as $word) {
            if (strpos($text, strtolower($word)) !== false) {
                return true;
            }
        }

        // Check for contextual profanity
        foreach ($this->contextualProfanity as $phrase) {
            if (strpos($text, strtolower($phrase)) !== false) {
                return true;
            }
        }

        // Check for repeated characters (like "fuuuuck")
        if ($this->hasRepeatedCharacters($text)) {
            return true;
        }

        // Check for character substitution (like f@ck, sh1t)
        if ($this->hasCharacterSubstitution($text)) {
            return true;
        }

        // Check for spaced out profanity (like "f u c k")
        if ($this->hasSpacedProfanity($text)) {
            return true;
        }

        return false;
    }

    private function normalizeText($text)
    {
        // Remove special characters, numbers, and extra spaces
        $text = preg_replace('/[^a-zA-Z\s]/', '', $text);
        $text = preg_replace('/\s+/', ' ', $text);
        $text = trim($text);
        
        // Handle common substitutions
        $substitutions = [
            '0' => 'o', '1' => 'i', '3' => 'e', '4' => 'a', '5' => 's',
            '7' => 't', '8' => 'b', '@' => 'a', '$' => 's', '!' => 'i',
            '*' => '', '+' => 't', '#' => 'h', '&' => 'and'
        ];
        
        foreach ($substitutions as $from => $to) {
            $text = str_replace($from, $to, $text);
        }
        
        return $text;
    }

    private function hasRepeatedCharacters($text)
    {
        // Check if profanity words have repeated characters
        foreach ($this->profanityWords as $word) {
            if (strlen($word) < 3) continue;
            
            // Create patterns with repeated characters
            for ($i = 0; $i < strlen($word); $i++) {
                $char = $word[$i];
                $pattern = substr($word, 0, $i) . $char . '{2,}' . substr($word, $i + 1);
                if (preg_match('/' . $pattern . '/i', $text)) {
                    return true;
                }
            }
        }
        return false;
    }

    private function hasCharacterSubstitution($text)
    {
        $commonSubstitutions = [
            'a' => ['@', '4', 'A'],
            'e' => ['3', 'E'],
            'i' => ['1', '!', 'I'],
            'o' => ['0', 'O'],
            's' => ['$', '5', 'S'],
            'u' => ['U'],
            'c' => ['(', 'C'],
            'k' => ['K'],
            't' => ['7', 'T']
        ];

        foreach ($this->profanityWords as $word) {
            $patterns = [$word];
            
            foreach ($commonSubstitutions as $letter => $subs) {
                $newPatterns = [];
                foreach ($patterns as $pattern) {
                    foreach ($subs as $sub) {
                        $newPatterns[] = str_replace($letter, '[' . $letter . $sub . ']', $pattern);
                    }
                }
                $patterns = array_merge($patterns, $newPatterns);
            }
            
            foreach ($patterns as $pattern) {
                if (preg_match('/' . $pattern . '/i', $text)) {
                    return true;
                }
            }
        }
        
        return false;
    }

    private function hasSpacedProfanity($text)
    {
        // Remove all spaces and check
        $noSpaceText = str_replace(' ', '', $text);
        
        foreach ($this->profanityWords as $word) {
            if (strpos($noSpaceText, $word) !== false) {
                return true;
            }
        }
        
        // Check for spaced out single characters
        $spacedPattern = preg_replace('/[a-z]/', '$0\\s*', $text);
        foreach ($this->profanityWords as $word) {
            if (preg_match('/' . $spacedPattern . '/i', $word)) {
                return true;
            }
        }
        
        return false;
    }

    public function cleanText($text)
    {
        $originalText = $text;
        $text = strtolower($text);
        
        foreach ($this->profanityWords as $word) {
            $replacement = str_repeat('*', strlen($word));
            $originalText = str_ireplace($word, $replacement, $originalText);
        }
        
        foreach ($this->contextualProfanity as $phrase) {
            $replacement = str_repeat('*', strlen($phrase));
            $originalText = str_ireplace($phrase, $replacement, $originalText);
        }
        
        return $originalText;
    }

    public function getProfanityReason($text)
    {
        $text = strtolower($text);
        $normalizedText = $this->normalizeText($text);
        
        foreach ($this->profanityWords as $word) {
            if (strpos($normalizedText, strtolower($word)) !== false) {
                return "Contains inappropriate language: '" . $word . "'";
            }
        }
        
        foreach ($this->contextualProfanity as $phrase) {
            if (strpos($normalizedText, strtolower($phrase)) !== false) {
                return "Contains inappropriate phrase: '" . $phrase . "'";
            }
        }
        
        if ($this->hasRepeatedCharacters($text)) {
            return "Contains inappropriate language with repeated characters";
        }
        
        if ($this->hasCharacterSubstitution($text)) {
            return "Contains inappropriate language with character substitution";
        }
        
        if ($this->hasSpacedProfanity($text)) {
            return "Contains inappropriate language with spacing";
        }
        
        return "Contains inappropriate content";
    }
}