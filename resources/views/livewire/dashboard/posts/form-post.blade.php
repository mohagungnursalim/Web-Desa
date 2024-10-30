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
                    <!-- Form input -->
                    <div class="form-group">
                        <label for="image">Gambar Postingan</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Gambar</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" id="image" class="custom-file-input" wire:model="image">
                                <label class="custom-file-label" for="image">
                                    @if ($image)
                                    File dipilih: {{ $image->getClientOriginalName() }}
                                    @else
                                    Pilih gambar
                                    @endif
                                </label>
                            </div>
                        </div>
                        @error('image') <span class="text-danger error">{{ $message }}</span> @enderror
                        <div class="d-flex flex-wrap mt-2">
                            @if ($image)

                            <div class="p-2">
                                <img src="{{ $image->temporaryUrl() }}" alt="Preview" class="img-fluid img-thumbnail"
                                    width="100px">
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
                    </div>

                    <div class="form-group">
                        <label for="title">Judul Postingan</label>
                        <input type="text" class="form-control" id="title" wire:model.defer="title"
                            placeholder="Masukan judul">
                        @error('title') <span class="text-danger error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Multiple Select untuk Kategori Post -->
                    <div wire:ignore class="form-group">
                        <label for="post_category">Kategori</label>
                        <select id="post_category" class="form-control" multiple wire:model="post_category">
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">
                                <p class="text-dark">{{ $category->name }}</p>
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @error('post_category') <span class="text-danger">{{ $message }}</span> @enderror

					 <!-- Multiple Select untuk Tag Post -->
					 <div wire:ignore class="form-group">
                        <label for="post_tag">Tagar</label>
                        <select id="post_tag" class="form-control" multiple wire:model="post_tag">
                            @foreach ($tags as $tag)
                            <option value="{{ $tag->id }}">
                                <p class="text-dark">{{ $tag->name }}</p>
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @error('post_tag') <span class="text-danger">{{ $message }}</span> @enderror

                    <div wire:ignore class="form-group">
                        <label for="description">Isi Konten</label>
                        <textarea class="form-control" id="editor" wire:model.defer="description"
                            placeholder="Masukan konten disini"></textarea>
                    </div>
                    @error('description') <span class="text-danger error">{{ $message }}</span>@enderror

                    <div class="text-center">
						<!-- Tombol untuk menyimpan data sebagai Draft -->
						<button style="border-radius: 10px;" type="button" class="btn btn-secondary" wire:loading.remove
							wire:click="saveAsDraft">Draft</button>
						<button style="border-radius: 10px;" type="button" class="btn btn-secondary" disabled wire:loading
							wire:target='saveAsDraft'>
							Menyimpan <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
						</button>
					
						<!-- Tombol untuk mempublikasikan postingan -->
						<button style="border-radius: 10px;" type="button" class="btn btn-primary" wire:loading.remove
							wire:click="publish">Publish</button>
						<button style="border-radius: 10px;" type="button" class="btn btn-primary" disabled wire:loading
							wire:target='publish'>
							Mempublikasikan <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
						</button>
					</div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
        integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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
			MediaEmbed, // Tambahkan MediaEmbed di sini
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
				MediaEmbed, // Pastikan MediaEmbed ada di sini
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
						label: 'Dapat diunduh',
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
	
		let debounceTimer;
	
		ClassicEditor
			.create(document.querySelector('#editor'), editorConfig)
			.then(editor => {
				// Debounce ketika ada perubahan pada editor
				editor.model.document.on('change:data', () => {
					clearTimeout(debounceTimer);
					debounceTimer = setTimeout(() => {
						@this.set('description', editor.getData()); // Update Livewire property
					}, 700); // Debounce selama 700ms
				});
			})
			.catch(error => {
				console.error(error);
			});
	
	</script>
	
	

    {{-- Select2 Kategori--}}
    <script>
        $(document).ready(function () {
            let debounceTimer;

            $('#post_category').select2({
                placeholder: '--Pilih Kategori--',
                minimumResultsForSearch: Infinity, // Menyembunyikan pencarian
                width: '100%', // Membuat Select2 menyesuaikan lebar field lainnya
            }).on('change', function (e) {
                clearTimeout(debounceTimer);

                debounceTimer = setTimeout(() => {
                    // Memperbarui model Livewire setelah debounce
                    @this.set('post_category', $(this).val());
                }, 700); // Debounce selama 700ms 
            });
        });

    </script>

	{{-- Select2 Tag--}}
    <script>
        $(document).ready(function () {
            let debounceTimer;

            $('#post_tag').select2({
                placeholder: '--Pilih Tagar--',
                minimumResultsForSearch: Infinity, // Menyembunyikan pencarian
                width: '100%', // Membuat Select2 menyesuaikan lebar field lainnya
            }).on('change', function (e) {
                clearTimeout(debounceTimer);

                debounceTimer = setTimeout(() => {
                    // Memperbarui model Livewire setelah debounce
                    @this.set('post_tag', $(this).val());
                }, 700); // Debounce selama 700ms 
            });
        });

    </script>

    @endpush
</div>
