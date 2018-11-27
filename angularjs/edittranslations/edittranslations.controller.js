/*!
 * Copyright (C) InnoCraft Ltd - All rights reserved.
 *
 * NOTICE:  All information contained herein is, and remains the property of InnoCraft Ltd.
 * The intellectual and technical concepts contained herein are protected by trade secret or copyright law.
 * Redistribution of this information or reproduction of this material is strictly forbidden
 * unless prior written permission is obtained from InnoCraft Ltd.
 *
 * You shall use this code only in accordance with the license agreement obtained from InnoCraft Ltd.
 *
 * @link https://www.innocraft.com/
 * @license For license details see https://www.innocraft.com/license
 */
(function () {
    angular.module('piwikApp').controller('CustomTranslationEdit', CustomTranslationEdit);

    CustomTranslationEdit.$inject = ['piwikApi', 'piwik', '$filter'];

    function CustomTranslationEdit(piwikApi, piwik, $filter) {
        var translate = $filter('translate');

        var self = this;
        this.languageCode = piwik.language || 'en';
        this.translationTypes = [];
        this.languageOptions = [];
        this.isUpdating = {};
        this.uiControlAttributes = {"field1":{"key":"key","title":translate('General_Value'),"uiControl":"text","availableValues":null},"field2":{"key":"value","title":translate('CustomTranslation_Translation'),"uiControl":"text","availableValues":null}};

        function hasTranslationValue(value)
        {
            return value !== '' && value !== false && value !== null;
        }

        var translationTypesPromise = piwikApi.fetch({method: 'CustomTranslation.getTranslatableTypes'});

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
                        method: 'CustomTranslation.getTranslationsForType',
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
               self.languageOptions.push({key: language.code, value: (language.english_name + ' (' + language.name+ ')')});
            });
        });

        this.update = function (idType) {
            this.isUpdating[idType] = true;
            var translations = {};
            angular.forEach(this.translations[idType], function (translation) {
                if (hasTranslationValue(translation.value)) {
                    translations[translation.key] = translation.value;
                }
            });
            piwikApi.post({
                method: 'CustomTranslation.updateTranslations',
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