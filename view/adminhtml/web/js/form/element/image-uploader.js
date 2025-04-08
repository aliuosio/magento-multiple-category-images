define([
    'jquery',
    'Magento_Ui/js/form/element/image-uploader'
], function ($, ImageUploader) {
    'use strict';

    return ImageUploader.extend({
        /**
         * Initialize observable properties
         * @returns {Object} Chainable
         */
        initObservable: function () {
            this._super();
            
            // Keep track of the add image button element
            this.addImageButton = null;
            
            return this;
        },

        /**
         * Callback after images are rendered
         * @param {Object} file - File object
         * @returns {Object} Chainable
         */
        addFile: function (file) {
            this._super(file);
            
            // After adding a file, ensure the add button is moved next to the last image
            this.moveAddButtonNextToLastImage();
            
            return this;
        },

        /**
         * Callback after image is removed
         * @param {String} fileId - File ID
         * @returns {Object} Chainable
         */
        removeFile: function (fileId) {
            this._super(fileId);
            
            // After removing a file, ensure the add button is moved next to the last image
            this.moveAddButtonNextToLastImage();
            
            return this;
        },

        /**
         * Renders the UI component
         * @returns {Object} Chainable
         */
        render: function () {
            this._super();
            
            // After initial render, ensure the add button is moved next to the last image
            this.moveAddButtonNextToLastImage();
            
            return this;
        },

        /**
         * Move the add image button next to the last image
         * @returns {Object} Chainable
         */
        moveAddButtonNextToLastImage: function () {
            var self = this;
            
            // Use setTimeout to ensure DOM is updated before we try to manipulate it
            setTimeout(function () {
                var container = $('#' + self.uid);
                var fileUploaderContainer = container.find('.file-uploader');
                var fileUploaderInner = container.find('.file-uploader-area');
                var imageContainer = container.find('.file-uploader-preview');
                
                // If this is the first time, save a reference to the add button container
                if (!self.addImageButton) {
                    self.addImageButton = fileUploaderInner.clone();
                }
                
                // If there are images, move the add button next to the last image
                if (imageContainer.length) {
                    // Remove the original button if it exists in its default location
                    fileUploaderInner.remove();
                    
                    // Add the button next to the last image
                    var lastImage = imageContainer.last();
                    self.addImageButton.insertAfter(lastImage.closest('.file-uploader-preview-container'));
                } else {
                    // If no images, ensure the add button is in its default location
                    if (fileUploaderInner.length === 0) {
                        fileUploaderContainer.append(self.addImageButton);
                    }
                }
            }, 100);
            
            return this;
        }
    });
});
