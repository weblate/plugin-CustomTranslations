/*!
 * InnoCraft - the company of the makers of Matomo Analytics, the free/libre analytics platform
 *
 * @link https://www.innocraft.com
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

(function () {
    angular.module('piwikApp').controller('CustomTranslationsEdit', CustomTranslationsEdit);

    CustomTranslationsEdit.$inject = ['piwikApi', 'piwik', '$filter'];

    function CustomTranslationsEdit(piwikApi, piwik, $filter) {
        var translate = $filter('translate');

        var self = this;
        this.languageCode = 'en';
        this.translationTypes = [];
        this.languageOptions = [];
        this.isUpdating = {};
        this.uiControlAttributes = {"field1":{"key":"key","title":translate('General_Value'),"uiControl":"text","availableValues":null},"field2":{"key":"value","title":translate('CustomTranslations_Translation'),"uiControl":"text","availableValues":null}};

        function hasTranslationValue(value)
        {
            return value !== '' && value !== false && value !== null;
        }

        var translationTypesPromise = piwikApi.fetch({method: 'CustomTranslations.getTranslatableTypes'});

        this.loadLanguage = function () {
            this.isLoadingTranslation = {};
            this.translations = {};
            this.isLoading = true;

            translationTypesPromise.then(function (translationTypes) {
                self.translations = {};
                self.translationTypes = translationTypes;
                angular.forEach(translationTypes, function (translationType) {
                    var idType = translationType.id;
                    self.isLoading = false;
                    self.isLoadingTranslation[idType] = true;
                    piwikApi.fetch({
                        method: 'CustomTranslations.getTranslationsForType',
                        idType: idType,
                        languageCode: self.languageCode}
                    ).then(function (translations) {
                        self.translations[idType] = [];

                        if (translations) {
                            angular.forEach(translations, function (translation, key) {
                                if (hasTranslationValue(translation)) {
                                    self.translations[idType].push({key: key, value: translation});
                                }
                            });
                        }
                        angular.forEach(translationType.translationKeys, function (translationKey) {
                            if (!translations[translationKey]) {
                                self.translations[idType].push({key: translationKey, value: ''});
                            }
                        });
                        self.isLoadingTranslation[idType] = false;
                    });
                });
            });
        }

        piwikApi.fetch({method: 'LanguagesManager.getAvailableLanguagesInfo'}).then(function (languages) {
            self.languageOptions = [];
            angular.forEach(languages, function (language) {
                var title = language.english_name;
                if (language.english_name !== language.name) {
                    title += ' (' + language.name + ')';
                }
                if (piwik.languageName === language.english_name || piwik.languageName === language.name) {
                    self.languageCode = language.code;
                }
                self.languageOptions.push({key: language.code, value: title});
            });
        });

        this.update = function (idType) {
            this.isUpdating[idType] = true;
            var translations = {};
            angular.forEach(this.translations[idType], function (translation) {
                if (translation.key && hasTranslationValue(translation.value)) {
                    translations[translation.key] = translation.value;
                }
            });
            piwikApi.post({
                method: 'CustomTranslations.setTranslations',
                idType: idType,
                languageCode: this.languageCode,
            }, {translations:translations}).then(function (languages) {
                self.isUpdating[idType] = false;
            }, function () {
                self.isUpdating[idType] = false;
            });
        };

        this.loadLanguage();
    }
})();