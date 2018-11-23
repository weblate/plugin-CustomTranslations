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
    angular.module('piwikApp').controller('CustomTranslationsEdit', CustomTranslationsEdit);

    CustomTranslationsEdit.$inject = ['piwikApi', 'piwik'];

    function CustomTranslationsEdit(piwikApi, piwik) {

        var self = this;
        this.language = piwik.language || 'en';
        this.translationTypes = [];
        this.languageOptions = [];
        this.translations = {};
        this.isUpdating = {};
        this.isLoadingTranslation = {};
        this.isLoading = true;

        piwikApi.fetch({method: 'CustomTranslations.getTranslatableTypes'}).then(function (translationTypes) {
            self.translations = {};
            self.translationTypes = translationTypes;
            angular.forEach(translationTypes, function (translationType) {
                self.isLoading = false;
                self.isLoadingTranslation[translationType.id] = false;
                piwikApi.fetch({
                    method: 'CustomTranslations.getTranslations',
                    idType: translationType.id,
                    languageCode: this.language}).then(function (translations) {
                    if (translations) {
                        self.translations[translationType.id] = translations;
                    }
                    angular.forEach(translationType.translationKeys, function (translationKey) {
                        if (!translations[translationKey]) {
                            self.translations[translationType.id][translationKey] = '';
                        }
                    });
                    self.isLoadingTranslation[translationType.id] = true;
                });
            });
        });

        piwikApi.fetch({method: 'LanguagesManager.getAvailableLanguagesInfo'}).then(function (languages) {
            self.languageOptions = [];
            angular.forEach(languages, function (language) {
               self.languageOptions.push({key: language.code, value: language.name});
            });
        });

        this.update = function (idType) {
            this.isUpdating[idType] = false;
            piwikApi.fetch({
                method: 'CustomTranslations.updateTranslations',
                idType: idType,
                languageCode: this.language,
            }, {translations:this.translations[idType]}).then(function (languages) {
                self.isUpdating[idType] = false;
            });

        }

    }
})();