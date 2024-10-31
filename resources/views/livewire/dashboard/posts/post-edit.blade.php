<div class="py-4">
    @push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
        integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.2.0/ckeditor5.css">
    <style>
        /* Ubah warna background dan teks untuk item yang dipilih */
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #1a1818;
            /* Ganti dengan warna yang Anda inginkan */
            color: #ffffff;
            /* Ganti dengan warna teks yang Anda inginkan */
            border: none;
        }

        /* Ubah warna saat hover pada item yang dipilih */
        .select2-container--default .select2-selection--multiple .select2-selection__choice:hover {
            background-color: #6d7a89;
            /* Ganti dengan warna hover yang Anda inginkan */
            color: #ffffff;
        }

    </style>
    <style>
        .ck-editor__editable[role="textbox"] {
            min-height: 300px;
            /* Atur tinggi minimal */
            max-height: 500px;
            /* Atur tinggi maksimal, jika diinginkan */
            overflow: auto;
            /* Agar bisa menggulir jika teks melebihi tinggi maksimal */
		}

    </style>
    @endpush
    <div class="container-fluid">
        <div class="card" style="border-radius: 25px;">
            <div class="card-body">
                <h4><a wire:navigate href="/dashboard/postingan" style="border-radius: 10px;"
                        class="btn btn-white"><u>👈Kembali</u></a></h4>
                <form>
                    
                    <div class="form-group">
						<label for="image">Gambar Postingan</label>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text">Gambar</span>
							</div>
							<div class="custom-file">
								<!-- Hapus atribut multiple dari input file -->
								<input type="file" id="image" class="custom-file-input" wire:model="image">
								<label class="custom-file-label" for="image">
									@if ($image)
										File dipilih: 1
									@else
										Pilih gambar
									@endif
								</label>
							</div>
						</div>
						@error('image') <span class="text-danger error">{{ $message }}</span> @enderror
					
						<!-- Preview gambar yang sudah ada di database -->
						@if($existingImage)
						<div class="d-flex flex-wrap">
							<div class="p-2">
								<img src="{{ asset('storage/' . $existingImage) }}" alt="Gambar Postingan"
									class="img-fluid img-thumbnail" width="100px">
							</div>
						</div>
						@else
						<p>Tidak ada gambar tersimpan.</p>
						@endif
					
						<!-- Preview gambar yang dipilih -->
						@if($image)
						<div class="mt-3 preview">
							<p>Preview Gambar Baru:</p>
							<div class="p-2">
								<img src="{{ $image->temporaryUrl() }}" alt="Preview Gambar"
									class="img-fluid img-thumbnail" width="100px">
							</div>
						</div>
						@endif
					</div>
					
					<div wire:loading wire:target="image" class="mt-2 col" style="width: 400px">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="100"
                                aria-valuemax="100">
                                Mengunggah...
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="title">Judul Postingan</label>
                        <input type="text" class="form-control" id="title" wire:model.defer="title"
                            placeholder="Masukan judul">
                        @error('title') <span class="text-danger error">{{ $message }}</span> @enderror
                    </div>

                   <!-- Multiple Select Kategori Post -->
					<div wire:ignore class="form-group">
						<label for="post_category">Kategori</label>
						<select id="post_category" class="form-control" multiple wire:model="selectedCategory">
							@foreach ($categories as $category)
							<option value="{{ $category->id }}"
								{{ in_array($category->id, $selectedCategory) ? 'selected' : '' }}>
								{{ $category->name }}
							</option>
							@endforeach
						</select>
					</div>
					@error('selectedCategory') <span class="text-danger">{{ $message }}</span> @enderror


					<!-- Multiple Select Tag Post -->
					<div wire:ignore class="form-group">
						<label for="post_tag">Tagar</label>
						<select id="post_tag" class="form-control" multiple wire:model="selectedTag">
							@foreach ($tags as $tag)
							<option value="{{ $tag->id }}"
								{{ in_array($tag->id, $selectedTag) ? 'selected' : '' }}>
								{{ $tag->name }}
							</option>
							@endforeach
						</select>
					</div>
					@error('selectedTag') <span class="text-danger">{{ $message }}</span> @enderror

                    <div wire:ignore class="form-group">
                        <label for="description">Isi Konten</label>
                        <textarea class="form-control" id="editor" wire:model.defer="description"
                            placeholder="Masukan konten disini"></textarea>
                    </div>
                    @error('description') <span class="text-danger error">{{ $message }}</span>@enderror

					
                   
                    <div class="text-center">
						<!-- Tombol untuk menyimpan data sebagai Draft -->
						<button style="border-radius: 10px;" type="button" class="btn btn-secondary" wire:loading.remove
							wire:click="update">Draf</button>
						<button style="border-radius: 10px;" type="button" class="btn btn-secondary" disabled wire:loading
							wire:target='update'>
							Menyimpan <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
						</button>
					
						<!-- Tombol untuk menerbitkan postingan -->
						<button style="border-radius: 10px;" type="button" class="btn btn-primary" wire:loading.remove
							wire:click="publishUpdate">Terbitkan</button>
						<button style="border-radius: 10px;" type="button" class="btn btn-primary" disabled wire:loading
							wire:target='publishUpdate'>
							Menerbitkan <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
						</button>
					
						<!-- Tombol untuk mengarsipkan postingan -->
						<button style="border-radius: 10px; background-color: #ffcc00; color: black;" type="button" class="btn" wire:loading.remove
							wire:click="archivePost">Arsipkan</button>
						<button style="border-radius: 10px; background-color: #ffcc00; color: black;" type="button" class="btn" disabled wire:loading
							wire:target='archivePost'>
							Mengarsipkan <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
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
					placeholder: 'Ketik atau paste konten Anda di sini!',
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
					}
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
									console.log('Updated description:', data); // Log data untuk debugging
									@this.set('description', data); // Update Livewire property
								}, 600); // 600ms debounce
							});
						})
						.catch(error => {
							console.error('Error initializing CKEditor:', error);
						});
				});



    </script>
	
	{{-- Select2 kategori form edit --}}
	<script>
		$(document).ready(function () {
			$('#post_category').select2({
				placeholder: '--Pilih Kategori--',
				minimumResultsForSearch: Infinity,
				width: '100%',
			});
	
			let debounceTimer;
			$('#post_category').on('change', function (e) {
				clearTimeout(debounceTimer);
				debounceTimer = setTimeout(() => {
					@this.set('selectedCategory', $(this).val());
				}, 700); // Menambahkan debounce 700ms
			});
	
			// Set initial value from Livewire
			const selectedCategorys = @json($selectedCategory ?? []);
			$('#post_category').val(selectedCategorys).trigger('change');
	
			// Update Select2 when Livewire updates the data
			Livewire.hook('message.processed', (message, component) => {
				$('#post_category').val(@json($selectedCategory ?? [])).trigger('change');
			});
		});
	</script>
	
	{{-- Select2 tag form edit --}}
	<script>
		$(document).ready(function () {
			$('#post_tag').select2({
				placeholder: '--Pilih Tagar--',
				minimumResultsForSearch: Infinity,
				width: '100%',
			});
	
			let debounceTimer;
			$('#post_tag').on('change', function (e) {
				clearTimeout(debounceTimer);
				debounceTimer = setTimeout(() => {
					@this.set('selectedTag', $(this).val());
				}, 700); // Menambahkan debounce 700ms
			});
	
			// Set initial value from Livewire
			const selectedTags = @json($selectedTag ?? []);
			$('#post_tag').val(selectedTags).trigger('change');
	
			// Update Select2 when Livewire updates the data
			Livewire.hook('message.processed', (message, component) => {
				$('#post_tag').val(@json($selectedTag ?? [])).trigger('change');
			});
		});
	</script>






    @endpush
</div>
