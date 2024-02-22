/**
 * @license Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

var jsonStyles = "../../../build/entrypoints.json";
let xhr = new XMLHttpRequest();
xhr.open('GET', jsonStyles, false);
xhr.send();

var baseFile = JSON.parse(xhr.responseText);
var cssFile = baseFile.entrypoints.app.css[0];

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	config.allowedContent = true;
	config.baseHref = '/';
	config.bodyClass = 'no-js';
	config.contentsCss = cssFile;
	config.defaultLanguage = 'fr';
	config.emailProtection = 'encode';
	config.entities = false;
	config.extraAllowedContent = 'i';
	config.extraPlugins = 'codemirror,templates,video,widget';
	config.height = 300;
	// config.startupMode = 'source'
};

CKEDITOR.on( 'dialogDefinition', function( ev ) {
    var dialogName = ev.data.name;
    var dialogDefinition = ev.data.definition;

    if ( dialogName == 'image' || dialogName == 'image2' ) {
        var infoTab = dialogDefinition.getContents( 'info' );
        if( dialogName == 'image' ){
            infoTab.remove('txtWidth');
            infoTab.remove('txtHeight');
            infoTab.remove('ratioLock');
        }
        else{
            infoTab.remove('width');
            infoTab.remove('height');
            infoTab.remove('lock');
        }
    }
});