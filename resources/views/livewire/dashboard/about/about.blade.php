<div class="py-4">
    @push('styles')
	<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.2.0/ckeditor5.css">
    @endpush
    <div class="container-fluid col-md">
        <div class="card" style="border-radius: 25px;">
            <div class="card-body">
  
                <form>
                    <div wire:ignore class="form-group">
                        <label for="description">Masukan deskripsi</label>
                        <textarea class="form-control" id="editor" wire:model.defer="description"
                            placeholder="Masukan konten disini"></textarea>
                    </div>
                    @error('description') <span class="text-danger error">{{ $message }}</span>@enderror

                    <div class="text-center">
						<button style="border-radius: 10px;" type="button" class="btn btn-secondary" wire:loading.remove
							wire:click="updateDescription">Simpan</button>
						<button style="border-radius: 10px;" type="button" class="btn btn-secondary" disabled wire:loading
							wire:target='updateDescription'>
							Menyimpan <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
						</button>
				
					</div>
                </form>

            </div>
        </div>
    </div>


    @push('scripts')

    <script type="importmap">
        {
                "imports": {
                    "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/43.2.0/ckeditor5.js",
                    "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/43.2.0/"
                }
            }
    </script>

    <script type="module">
        import {
					ClassicEditor,
					AccessibilityHelp,
					Alignment,
					Autoformat,
					AutoImage,
					AutoLink,
					Autosave,
					Base64UploadAdapter,
					BlockQuote,
					BlockToolbar,
					Bold,
					CloudServices,
					Code,
					CodeBlock,
					Essentials,
					FindAndReplace,
					FontBackgroundColor,
					FontColor,
					FontFamily,
					FontSize,
					GeneralHtmlSupport,
					Heading,
					Highlight,
					HorizontalLine,
					ImageBlock,
					ImageCaption,
					ImageInline,
					ImageInsert,
					ImageInsertViaUrl,
					ImageResize,
					ImageStyle,
					ImageTextAlternative,
					ImageToolbar,
					ImageUpload,
					Indent,
					IndentBlock,
					Italic,
					Link,
					LinkImage,
					List,
					ListProperties,
					MediaEmbed,
					Paragraph,
					RemoveFormat,
					SelectAll,
					SourceEditing,
					SpecialCharacters,
					SpecialCharactersArrows,
					SpecialCharactersCurrency,
					SpecialCharactersEssentials,
					SpecialCharactersLatin,
					SpecialCharactersMathematical,
					SpecialCharactersText,
					Strikethrough,
					Style,
					Subscript,
					Superscript,
					Table,
					TableCaption,
					TableCellProperties,
					TableColumnResize,
					TableProperties,
					TableToolbar,
					TextTransformation,
					TodoList,
					Underline,
					Undo
				} from 'ckeditor5';

				const editorConfig = {
					toolbar: {
						items: [
							'undo',
							'redo',
							'|',
							'sourceEditing',
							'|',
							'heading',
							'style',
							'|',
							'fontSize',
							'fontFamily',
							'fontColor',
							'fontBackgroundColor',
							'|',
							'bold',
							'italic',
							'underline',
							'|',
							'link',
							'insertImage',
							'insertTable',
							'highlight',
							'blockQuote',
							'codeBlock',
							'|',
							'alignment',
							'|',
							'bulletedList',
							'numberedList',
							'todoList',
							'outdent',
							'indent'
						],
						shouldNotGroupWhenFull: false
					},
					plugins: [
						AccessibilityHelp,
						Alignment,
						Autoformat,
						AutoImage,
						AutoLink,
						Autosave,
						Base64UploadAdapter,
						BlockQuote,
						BlockToolbar,
						Bold,
						CloudServices,
						Code,
						CodeBlock,
						Essentials,
						FindAndReplace,
						FontBackgroundColor,
						FontColor,
						FontFamily,
						FontSize,
						GeneralHtmlSupport,
						Heading,
						Highlight,
						HorizontalLine,
						ImageBlock,
						ImageCaption,
						ImageInline,
						ImageInsert,
						ImageInsertViaUrl,
						ImageResize,
						ImageStyle,
						ImageTextAlternative,
						ImageToolbar,
						ImageUpload,
						Indent,
						IndentBlock,
						Italic,
						Link,
						LinkImage,
						List,
						ListProperties,
						MediaEmbed,
						Paragraph,
						RemoveFormat,
						SelectAll,
						SourceEditing,
						SpecialCharacters,
						SpecialCharactersArrows,
						SpecialCharactersCurrency,
						SpecialCharactersEssentials,
						SpecialCharactersLatin,
						SpecialCharactersMathematical,
						SpecialCharactersText,
						Strikethrough,
						Style,
						Subscript,
						Superscript,
						Table,
						TableCaption,
						TableCellProperties,
						TableColumnResize,
						TableProperties,
						TableToolbar,
						TextTransformation,
						TodoList,
						Underline,
						Undo
					],
					blockToolbar: [
						'fontSize',
						'fontColor',
						'fontBackgroundColor',
						'|',
						'bold',
						'italic',
						'|',
						'link',
						'insertImage',
						'insertTable',
						'|',
						'bulletedList',
						'numberedList',
						'outdent',
						'indent'
					],
					fontFamily: {
						supportAllValues: true
					},
					fontSize: {
						options: [10, 12, 14, 'default', 18, 20, 22],
						supportAllValues: true
					},
					heading: {
						options: [
							{
								model: 'paragraph',
								title: 'Paragraph',
								class: 'ck-heading_paragraph'
							},
							{
								model: 'heading1',
								view: 'h1',
								title: 'Heading 1',
								class: 'ck-heading_heading1'
							},
							{
								model: 'heading2',
								view: 'h2',
								title: 'Heading 2',
								class: 'ck-heading_heading2'
							},
							{
								model: 'heading3',
								view: 'h3',
								title: 'Heading 3',
								class: 'ck-heading_heading3'
							},
							{
								model: 'heading4',
								view: 'h4',
								title: 'Heading 4',
								class: 'ck-heading_heading4'
							},
							{
								model: 'heading5',
								view: 'h5',
								title: 'Heading 5',
								class: 'ck-heading_heading5'
							},
							{
								model: 'heading6',
								view: 'h6',
								title: 'Heading 6',
								class: 'ck-heading_heading6'
							}
						]
					},
					htmlSupport: {
						allow: [
							{
								name: /^.*$/,
								styles: true,
								attributes: true,
								classes: true
							}
						]
					},
					image: {
						toolbar: [
							'toggleImageCaption',
							'imageTextAlternative',
							'|',
							'imageStyle:inline',
							'imageStyle:wrapText',
							'imageStyle:breakText',
							'|',
							'resizeImage'
						]
					},
					
					link: {
						addTargetToExternalLinks: true,
						defaultProtocol: 'https://',
						decorators: {
							toggleDownloadable: {
								mode: 'manual',
								label: 'Downloadable',
								attributes: {
									download: 'file'
								}
							}
						}
					},
					list: {
						properties: {
							styles: true,
							startIndex: true,
							reversed: true
						}
					},
					menuBar: {
						isVisible: true
					},
					placeholder: 'Ketik atau paste deskripsi Anda di sini!',
					style: {
						definitions: [
							{
								name: 'Article category',
								element: 'h3',
								classes: ['category']
							},
							{
								name: 'Title',
								element: 'h2',
								classes: ['document-title']
							},
							{
								name: 'Subtitle',
								element: 'h3',
								classes: ['document-subtitle']
							},
							{
								name: 'Info box',
								element: 'p',
								classes: ['info-box']
							},
							{
								name: 'Side quote',
								element: 'blockquote',
								classes: ['side-quote']
							},
							{
								name: 'Marker',
								element: 'span',
								classes: ['marker']
							},
							{
								name: 'Spoiler',
								element: 'span',
								classes: ['spoiler']
							},
							{
								name: 'Code (dark)',
								element: 'pre',
								classes: ['fancy-code', 'fancy-code-dark']
							},
							{
								name: 'Code (bright)',
								element: 'pre',
								classes: ['fancy-code', 'fancy-code-bright']
							}
						]
					},
					table: {
						contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells', 'tableProperties', 'tableCellProperties']
					},
					height: '300px' // Atur tinggi editor di sini
				};

				$(document).ready(function () {
					let debounceTimer;

					ClassicEditor
						.create(document.querySelector('#editor'), editorConfig)
						
						.then(editor => {
							// Debounce ketika ada perubahan pada editor
							editor.model.document.on('change:data', () => {
								// Reset debounceTimer setiap kali ada perubahan
								clearTimeout(debounceTimer);
								
								debounceTimer = setTimeout(() => {
									const data = editor.getData();
									@this.set('description', data); // Update Livewire property
								}, 600); // 600ms debounce
							});
						})
						.catch(error => {
							console.error('Error initializing CKEditor:', error);
						});
				});



    </script>

	<script>
		$(document).ready(function () {
			window.addEventListener('updateSuccess', function (event) {
				Swal.fire({
					toast: true, // Mengatur untuk menampilkan sebagai toast
					position: 'top-end', // Posisi toast
					icon: 'success',
					title: 'Sukses!',
					text: 'Deskripsi berhasil diperbarui!',
					showCloseButton: true, // Tampilkan tombol close
					timer: 3000, // Durasi tampilnya toast dalam ms
					timerProgressBar: true, // Tampilkan progress bar
					showConfirmButton: false // Sembunyikan tombol konfirmasi
				});
			});
		});
	</script>


    @endpush
</div>
