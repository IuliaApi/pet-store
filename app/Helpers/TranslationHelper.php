<?php

declare(strict_types=1);

namespace App\Helpers;

use InvalidArgumentException;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\JsonFileLoader;

class TranslationHelper
{
    private Translator $translator;
    private string $currentLocale;
    private string $defaultLocale;
    private string $langPath;
    private array $availableLocales;

    /**
     * @param string $langPath Path to language files directory
     * @param string $defaultLocale Default locale (fallback)
     * @param array $availableLocales List of available locales
     */
    public function __construct(
        string $langPath,
        string $defaultLocale = 'en',
        array $availableLocales = ['en', 'fr']
    ) {
        // TODO: Initialize class properties, create a Translator instance,
        //       configure the fallback locale, register the JSON file loader,
        //       and load all translation files.
        $this->defaultLocale = $defaultLocale;
        $this->langPath = $langPath;
        $this->availableLocales = $availableLocales;
        $this->translator = new Translator($this->defaultLocale);
        $this->setLocale($defaultLocale);
        $this->translator->addLoader('json', new JsonFileLoader());
        $this->translator->setFallbackLocales($this->availableLocales);
        $this->translator->addResource('json', APP_LANG_PATH . "/en/messages.json", $this->defaultLocale);
        $this->loadTranslations();
    }

    /**
     * Load translation files for all available locales.
     */
    private function loadTranslations(): void
    {
        // TODO: Loop through available locales, build the file path to each
        //       locale's messages.json, and register each existing file
        //       with the translator.
        foreach ($this->availableLocales as $locale) {
            $translation_path = $this->langPath . DIRECTORY_SEPARATOR . $locale . DIRECTORY_SEPARATOR . "messages.json";
            $this->translator->addResource('json', $translation_path, $locale);
        }
    }

    /**
     * Translate a message.
     *
     * @param string $key Translation key (supports dot notation: 'home.welcome')
     * @param array $parameters Parameters to replace in translation
     * @param string|null $locale Override current locale for this translation
     * @return string Translated message
     */
    public function trans(string $key, array $parameters = [], ?string $locale = null): string
    {
        // TODO: Translate the given key using the current locale
        //       (or the override locale if provided).
        return $this->translator->trans($key, $parameters, null, $locale);
    }

    /**
     * Set the current locale.
     *
     * @param string $locale Locale code (e.g., 'en', 'fr')
     * @throws \InvalidArgumentException If locale is not available
     */
    public function setLocale(string $locale): void
    {
        // TODO: Validate that the locale is available, then update both
        //       the class property and the translator.
        if (!in_array($locale, $this->availableLocales)) {
            throw new InvalidArgumentException('The requested locale is NOT supported');
        }
        $this->currentLocale = $locale;
        $this->translator->setLocale($locale);
    }

    // TODO: Implement the following getter methods that return
    //       the corresponding class properties:
    //       - getLocale(): string
    //       - getDefaultLocale(): string
    //       - getAvailableLocales(): array
    //       - isLocaleAvailable(string $locale): bool
    public function getLocale(): string
    {
        return $this->currentLocale;
    }
    public function getDefaultLocale(): string
    {
        return $this->defaultLocale;
    }
    public function getAvailableLocales(): array
    {
        return $this->availableLocales;
    }
    public function isLocaleAvailable(string $locale): bool
    {
        return in_array($locale, $this->availableLocales);
    }
}
