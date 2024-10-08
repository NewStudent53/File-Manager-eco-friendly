import * as THREE from 'three';

			import { Editor } from '../js/Editor.js'
			import { Player } from '../js/Player.js';
			import { Sidebar } from '../js/Sidebar.js';
			import { Menubar } from '../js/Menubar.js';
			import { Resizer } from '../js/Resizer.js';
			import { VRButton } from 'three/addons/webxr/VRButton.js';

			window.URL = window.URL || window.webkitURL;
			window.BlobBuilder = window.BlobBuilder || window.WebKitBlobBuilder || window.MozBlobBuilder;

			Number.prototype.format = function () {

				return this.toString().replace( /(\d)(?=(\d{3})+(?!\d))/g, '$1,' );

			};

			//

			const editor = new Editor();

			window.editor = editor; 
			window.THREE = THREE; 
			window.VRButton = VRButton; 

			const player = new Player( editor );
			document.body.appendChild( player.dom );

			const sidebar = new Sidebar( editor );
			document.body.appendChild( sidebar.dom );

			const menubar = new Menubar( editor );
			document.body.appendChild( menubar.dom );

			const resizer = new Resizer( editor );
			document.body.appendChild( resizer.dom );

			//

			editor.storage.init( function () {

				editor.storage.get( function ( state ) {

					if ( isLoadingFromHash ) return;

					if ( state !== undefined ) {

						editor.fromJSON( state );

					}

					const selected = editor.config.getKey( 'selected' );

					if ( selected !== undefined ) {

						editor.selectByUuid( selected );

					}

				} );

				//

				let timeout;

				function saveState() {

					if ( editor.config.getKey( 'autosave' ) === false ) {

						return;

					}

					clearTimeout( timeout );

					timeout = setTimeout( function () {

						editor.signals.savingStarted.dispatch();

						timeout = setTimeout( function () {

							editor.storage.set( editor.toJSON() );

							editor.signals.savingFinished.dispatch();

						}, 100 );

					}, 1000 );

				}

				const signals = editor.signals;

				signals.geometryChanged.add( saveState );
				signals.objectAdded.add( saveState );
				signals.objectChanged.add( saveState );
				signals.objectRemoved.add( saveState );
				signals.materialChanged.add( saveState );
				signals.sceneBackgroundChanged.add( saveState );
				signals.sceneEnvironmentChanged.add( saveState );
				signals.sceneFogChanged.add( saveState );
				signals.sceneGraphChanged.add( saveState );
				signals.historyChanged.add( saveState );

			} );

			//

			document.addEventListener( 'dragover', function ( event ) {

				event.preventDefault();
				event.dataTransfer.dropEffect = 'copy';

			} );

			document.addEventListener( 'drop', function ( event ) {

				event.preventDefault();

				if ( event.dataTransfer.types[ 0 ] === 'text/plain' ) return; // Outliner drop

				if ( event.dataTransfer.items ) {

					// DataTransferItemList supports folders

					editor.loader.loadItemList( event.dataTransfer.items );

				} else {

					editor.loader.loadFiles( event.dataTransfer.files );

				}

			} );

			function onWindowResize() {

				editor.signals.windowResize.dispatch();

			}

			window.addEventListener( 'resize', onWindowResize );

			onWindowResize();

			//

			let isLoadingFromHash = false;
			const hash = window.location.hash;

			if ( hash.slice( 1, 6 ) === 'file=' ) {

				const file = hash.slice( 6 );

				if ( confirm( 'Any unsaved data will be lost. Are you sure?' ) ) {

					const loader = new THREE.FileLoader();
					loader.crossOrigin = '';
					loader.load( file, function ( text ) {

						editor.clear();
						editor.fromJSON( JSON.parse( text ) );

					} );

					isLoadingFromHash = true;

				}

			}