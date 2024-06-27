<?php

namespace App\Traits;

trait ModelLanguages
{
    protected  $l = [];
    /**
     * Get languages attributes
     *
     * @param  string $attribute attribute name
     * @param  string $locale
     * @return strinf
     */
    public function language($attribute, $locale = null)
    {
        $locale = $locale ? $locale : session('lang');

        if (!isset($this->l[$locale])) {
            if($this->getAttribute('languages')) {
                $this->l[$locale] = $this->getAttribute('languages')->where('locale', $locale)->first();
            } else {
                $this->l[$locale] = $this->languages()->where('locale', $locale)->first();
            }

        }

        if ($this->l[$locale]) {
            return $this->l[$locale]->{$attribute};
        }

    }

    /**
     * Saved all languages attrivutes
     *
     * @param  array $request
     * @param  array $languages
     * @return void
     */
    public function saveLanguages($request, $languages = [])
    {
        $languages = $languages ? $languages : config('cnv.languages');
        foreach ($languages as $language) {
            $item = $this->languages()->where('locale', $language['locale'])->first();

            if (isset($request['language'][$language['locale']])) {
                $data = array_merge([
                    'locale' => $language['locale']
                ], $request['language'][$language['locale']]);

                if(isset($data['description'])) {
                    $data['description'] = str_limit($data['description'], 157);
                }
                if(isset($data['title'])) {
                    $data['title'] =  str_limit($data['title'], 67);
                }
                if(isset($data['slug'])) {
                    $data['slug'] =  \App\Libraries\Str::friendlySlug(!$data['slug'] ? @$data['name'] : @$data['slug']);
                }

                $emptyLanguage = true;
                foreach ($data as $field => $value) {
                    if($value && $field !== 'locale' && !is_array($value)) {
                        $emptyLanguage = false;
                        break;
                    }
                }

                if($emptyLanguage && !$item) {
                    continue;
                }

                if ($item) {
                    $item->update($data);
                } else {
                    @$this->languages()->create($data);
                }
            }
        }
    }
}
