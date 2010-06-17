/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
};


CKEDITOR.editorConfig = function( config )
{
		config.height = 500;
	  config.toolbar = 'MyToolbar';
    config.toolbar_MyToolbar =
    [
        ['NewPage','Preview'],
        ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Scayt'],
        ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
        ['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
        '/',
        ['TextColor','Styles','Format'],
        ['Bold','Italic','Underline','Strike'],
        ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
        ['Link','Unlink','Anchor'],
        ['Maximize','-','About']
    ];
    config.toolbar_MyToolbarShort =
    [
        ['Cut','Copy','Paste'],
        ['Find','Replace','-','SelectAll','RemoveFormat'],
        ['TextColor','Styles','Format'],
        ['Bold','Italic','Underline','Strike'],
        ['NumberedList','BulletedList'],
    ];
};
