<!--
  Matomo - free/libre analytics platform
  @link https://matomo.org
  @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
-->

<todo>
- get to build
- test in UI
- create PR
</todo>

<template>
  <div class="editCustomTranslations">
    <ContentBlock :content-title="translate('CustomTranslations_CustomTranslations')">
      <div class="languageCode">
        <Field
          uicontrol="select"
          name="language"
          :model-value="languageCode"
          @update:model-value="languageCode = $event; loadLanguage()"
          :title="translate('General_Language')"
          :options="languageOptions"
          :inline-help="translate('CustomTranslations_LanguageInlineHelp')"
        >
        </Field>
      </div>
      <p>{{ translate('General_GoTo2') }} <span
          v-for="(translationType, index) in translationTypes"
          :key="translationType.id"
        >
          <a :href="`#idType${translationType.id}`">{{ translationType.name }}</a>
          <span v-show="index !== translationTypes.length - 1"> | </span>
        </span>
      </p>
      <ActivityIndicator :loading="isLoading" />
      <div
        :class="`translationType translationType${translationType.id}`"
        v-for="translationType in translationTypes"
        :key="translationType.id"
      >
        <a :name="`idType${translationType.id}`" />
        <h3>{{ translationType.name }}</h3>
        <ActivityIndicator :loading="isLoadingTranslation[translationType.id]" />
        <div>
          <Field
            uicontrol="multituple"
            name="multitupletext"
            :title="translationType.description"
            v-model="translations[translationType.id]"
            :full-width="true"
            :ui-control-attributes="uiControlAttributes"
          >
          </Field>
        </div>
        <SaveButton
          @confirm="update(translationType.id)"
          :saving="isUpdating[translationType.id]"
          :disabled="isUpdating[translationType.id]"
        />
      </div>
    </ContentBlock>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import {
  translate,
  AjaxHelper,
  Matomo,
  ContentBlock,
  ActivityIndicator,
} from 'CoreHome';
import { Field, SaveButton } from 'CorePluginsAdmin';

interface TranslationType {
  id: string;
  name: string;
  description: string;
  translationKeys: string[];
}

interface Option {
  key: string;
  value: string;
}

interface Language {
  english_name: string;
  name: string;
  code: string;
}

interface EditCustomTranslationsState {
  languageCode: string;
  translationTypes: TranslationType[];
  languageOptions: Option[];
  isUpdating: Record<string, boolean>;
  translations: Record<string, Option[]>;
  isLoadingTranslation: Record<string, boolean>;
  isLoading: boolean;
}

function hasTranslationValue(value: unknown): boolean {
  return value !== '' && value !== false && value !== null;
}

export default defineComponent({
  props: {
  },
  components: {
    ContentBlock,
    Field,
    ActivityIndicator,
    SaveButton,
  },
  data(): EditCustomTranslationsState {
    return {
      languageCode: 'en',
      translationTypes: [],
      languageOptions: [],
      isUpdating: {},
      translations: {},
      isLoadingTranslation: {},
      isLoading: false,
    };
  },
  setup() {
    const translationTypesPromise = AjaxHelper.fetch<TranslationType[]>({
      method: 'CustomTranslations.getTranslatableTypes',
    });

    return {
      translationTypesPromise,
    };
  },
  created() {
    AjaxHelper.fetch<Language[]>({
      method: 'LanguagesManager.getAvailableLanguagesInfo',
    }).then((languages) => {
      this.languageOptions = [];
      languages.forEach((language) => {
        let title = language.english_name;
        if (language.english_name !== language.name) {
          title += ` (${language.name})`;
        }

        if (Matomo.languageName === language.english_name
          || Matomo.languageName === language.name
        ) {
          this.languageCode = language.code;
        }

        this.languageOptions.push({
          key: language.code,
          value: title,
        });
      });
    });

    this.loadLanguage();
  },
  methods: {
    loadLanguage() {
      this.isLoadingTranslation = {};
      this.translations = {};
      this.isLoading = true;

      this.translationTypesPromise.then((translationTypes) => {
        this.translations = {};
        this.translationTypes = translationTypes;
        translationTypes.forEach((translationType) => {
          const idType = translationType.id;
          this.isLoading = false;
          this.isLoadingTranslation[idType] = true;

          AjaxHelper.fetch<Record<string, string>>({
            method: 'CustomTranslations.getTranslationsForType',
            idType,
            languageCode: this.languageCode,
          }).then((translations) => {
            this.translations[idType] = [];

            if (translations) {
              Object.entries(translations).forEach(([key, translation]) => {
                if (hasTranslationValue(translation)) {
                  this.translations[idType].push({
                    key,
                    value: translation,
                  });
                }
              });
            }

            translationType.translationKeys.forEach((translationKey) => {
              if (!translations[translationKey]) {
                this.translations[idType].push({
                  key: translationKey,
                  value: '',
                });
              }
            });

            this.isLoadingTranslation[idType] = false;
          });
        });
      });
    },
    update(idType: string) {
      this.isUpdating[idType] = true;

      const translations: Record<string, string> = {};
      this.translations[idType].forEach((translation) => {
        if (translation.key && hasTranslationValue(translation.value)) {
          translations[translation.key] = translation.value;
        }
      });

      AjaxHelper.post(
        {
          method: 'CustomTranslations.setTranslations',
          idType,
          languageCode: this.languageCode,
        },
        {
          translations,
        },
      ).finally(() => {
        this.isUpdating[idType] = false;
      });
    },
  },
  computed: {
    uiControlAttributes() {
      return {
        field1: {
          key: 'key',
          title: translate('General_Value'),
          uiControl: 'text',
          availableValues: null,
        },
        field2: {
          key: 'value',
          title: translate('CustomTranslations_Translation'),
          uiControl: 'text',
          availableValues: null,
        },
      };
    },
  },
});
</script>
