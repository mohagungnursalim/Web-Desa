<div class="py-4">
    @push('styles')
    <style>
    .ck-editor__editable {
        min-height: 300px;
    }
    </style>
    @endpush
    <div class="container-fluid col-md">
        <div class="card" style="border-radius: 25px;">
            <div class="card-body">
                <!-- Tombol untuk membuka modal -->
                <button style="border-radius: 10px;" id="openModalBtn"
                    class="btn btn-primary mb-4 d-block d-md-inline-block">Tambah </button>


                <!-- Input untuk mencari -->
                <div class="mb-2">
                    <input style="border-radius: 10px;" type="text" wire:model.live.debounce.500ms="search"
                        placeholder="Cari.." class="form-control" style="color: black;">

                    &nbsp;&nbsp;<a wire:loading wire:target='search' class="text-secondary">Mencari..</a>
                </div>

                <div wire:init="loadInitialLayanans">
                    <table class="table table-responsive-md">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Dibuat</th>
                                <th>Diperbarui</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>


                            @forelse ($layanans as $index => $layanan)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $layanan->title }}</td>
                                <td>
                                    {!! \Illuminate\Support\Str::limit(strip_tags($layanan->description), 30) !!}
                                </td>
                                <td>{{ $layanan->created_at }}</td>
                                <td>{{ $layanan->updated_at }}</td>
                                <td>
                                    <!-- Tombol untuk membuka modal update -->
                                    <button style="border-radius: 10px;"
                                        wire:click="openUpdateModal({{ $layanan->id }})" class="btn btn-primary">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>

                                    <!-- Tombol untuk membuka modal delete -->
                                    <button style="border-radius: 10px;"
                                        wire:click="confirmDelete({{ $layanan->id }}, '{{ $layanan->title }}' )"
                                        type="button" class="btn btn-danger text-white">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td wire:loading.remove wire:target="loadInitialLayanans" colspan="7" class="text-center">Tidak ada data yang ditemukan.</td>
                            </tr>
                            @endforelse


                        </tbody>
                    </table>
                    <div class="text-center">
                        <!-- Loading saat memuat data pertama kali -->
                        <p wire:loading wire:target="loadInitialLayanans" class="text-center">Memuat data..<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                        </p>
                    </div>
                </div>

                <!-- Tombol Load More -->
                @if($layanans->count() >= $limit && $totalLayanans > $limit)
                <div class="mt-4 d-flex justify-content-center">
                    <!-- Tombol "Tampilkan Lebih" (akan hilang saat loading) -->
                    <button style="border-radius: 20px;" wire:click="loadMore" class="btn btn-dark btn-rounded"
                        wire:loading.remove wire:target="loadMore">
                        Tampilkan Lebih
                    </button>

                    <!-- Tombol Loading (hanya muncul saat loading) -->
                    <button style="border-radius: 20px;" class="btn btn-dark  btn-rounded" type="button" disabled
                        wire:loading wire:target="loadMore">
                        Memuat.. <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                    </button>
                </div>
                @endif


            </div>
        </div>
    </div>


    {{-- ----------------Modal------------------------ --}}


    <!-- Modal Tambah Data -->
    <div id="addLayananModal" class="modal" tabindex="-1" role="dialog" wire:ignore>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="border-radius: 20px;">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="max-height: 75vh; overflow-y: auto;">
                    <form wire:submit.prevent="store">
                        <div class="form-group">
                            <label for="title">Judul</label>
                            <input type="text" placeholder="Masukan judul.." class="form-control" id="title"
                                wire:model="title">
                            @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
						<div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea class="form-control" id="editor" wire:model="description"
                            placeholder="Masukan konten disini"></textarea>
                            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <button style="border-radius: 10px;" type="button" class="btn btn-secondary" data-dismiss="modal"
                        wire:loading.remove wire:target="store">Tutup</button>
                    <button style="border-radius: 10px;" type="button" class="btn btn-primary" wire:loading.remove
                        wire:click="store">Simpan</button>
                    <button style="border-radius: 10px;" type="button" class="btn btn-primary" disabled wire:loading
                        wire:target="store">
                        Menyimpan <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Edit -->
    <div class="modal fade" id="editLayananModal" tabindex="-1" role="dialog" wire:ignore>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="border-radius: 20px;">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="max-height: 75vh; overflow-y: auto;">
                    <form wire:submit.prevent="update">
                        <div class="form-group">
                            <label for="layananTitle">Judul</label>
                            <input type="text" class="form-control" id="layananTitle" wire:model="layananTitle">
                            @error('layananTitle') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="layananDescription">Deskripsi</label>
                            <textarea class="form-control" id="editorEdit" wire:model="layananDescription"
                            placeholder="Masukan konten disini"></textarea>
                            @error('layananDescription') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        

                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <button style="border-radius: 10px;" type="button" class="btn btn-secondary" wire:loading.remove
                        wire:target='update' data-dismiss="modal" aria-label="Close">Tutup</button>
                    <button style="border-radius: 10px;" type="button" class="btn btn-primary" wire:loading.remove
                        wire:click="update">Simpan</button>
                    <button style="border-radius: 10px;" type="button" class="btn btn-primary" disabled wire:loading
                        wire:target='update'>
                        Menyimpan <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Delete --}}
    <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="border-radius: 20px;">
                <div class="modal-header">
                    <h6 class="modal-title" id="deleteModalLabel">
                        Hapus Data "{{ $layananTitle }}"
                    </h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    Apakah anda yakin ingin menghapus data ini?
                </div>
                <div class="modal-footer justify-content-center">
                    <button style="border-radius: 10px;" wire:loading.remove wire:target='delete' type="button"
                        class="btn btn-secondary" data-dismiss="modal">Batal
                    </button>
                    <button style="border-radius: 10px;" wire:loading.remove wire:click="delete" type="button"
                        class="btn btn-danger">Hapus
                    </button>

                    <button style="border-radius: 10px;" wire:loading wire:target='delete' class="btn btn-danger"
                        disabled>
                        Menghapus <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')

    {{-- Add Form Ckeditor5 --}}
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
					}, 800); // Debounce selama 800ms
				});
			})
			.catch(error => {
				console.error(error);
			});
	
	</script>

    {{-- Edit Form Ckeditor5 --}}
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

                // Inisialisasi CKEditor
                ClassicEditor
                    .create(document.querySelector('#editorEdit'), editorConfig)
                    .then(editor => {
                        // Debounce ketika ada perubahan pada editor
                        editor.model.document.on('change:data', () => {
                            // Reset debounceTimer setiap kali ada perubahan
                            clearTimeout(debounceTimer);
                            
                            debounceTimer = setTimeout(() => {
                                const data = editor.getData();
                                @this.set('layananDescription', data); // Update Livewire property
                            }, 600); // 600ms debounce
                        });

                        // Pastikan data awal dimuat saat modal dibuka
                        $('#editLayananModal').on('show.bs.modal', function () {
                            setTimeout(() => {
                                if (editor) {
                                    editor.setData(@this.layananDescription); // Memuat data dari Livewire
                                }
                            }, 300); // Tunggu beberapa milidetik agar modal terbuka sepenuhnya
                        });

                    })
                    .catch(error => {
                        console.error('Error initializing CKEditor:', error);
                    });
        });

    </script>

    {{-- Add Modal Form --}}
    <script>
        $(document).ready(function () {
            // Membuka modal ketika tombol ditekan
            $('#openModalBtn').click(function () {
                $('#addLayananModal').modal('show');
            });

            // Mendengarkan event dari Livewire untuk menutup modal
            window.addEventListener('closeAddLayananModal', function (event) {
                $('#addLayananModal').modal('hide'); // Menutup modal
            });

            // Reset form di backend setelah modal ditutup
            $('#addLayananModal').on('hidden.bs.modal', function (e) {
                @this.call('resetForm'); // Reset input form di Livewire
            });

            // Jika modal ditutup, hapus backdrop jika ada
            $('#addLayananModal').on('hidden.bs.modal', function (e) {
                $('.modal-backdrop').remove(); // Hapus backdrop
            });
        });

    </script>

    {{-- Edit Modal Form --}}
    <script>
        $(document).ready(function () {
            // Membuka modal edit
            window.addEventListener('openEditLayananModal', function (e) {
                $('#editLayananModal').modal('show');
            });

            // Menutup modal
            window.addEventListener('closeUpdatedModal', function (e) {
                $('#editLayananModal').modal('hide');

                // Hapus backdrop
                $('#editLayananModal').on('hidden.bs.modal', function (e) {
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                });
            });

            // Reset form
            $('#editLayananModal').on('hidden.bs.modal', function (e) {
                @this.call('resetForm');
            })

        })

    </script>

    {{-- Sweet alert,added success --}}
    <script>
        $(document).ready(function () {
            window.addEventListener('addedSuccess', function (event) {
                Swal.fire({
                    title: "Sukses!",
                    text: "Berhasil ditambahkan!",
                    icon: "success",
                    timer: 1000,
                    timerProgressBar: true,
                });
            });
        })

    </script>

    {{-- Sweet alert,layananUpdated success --}}
    <script>
        $(document).ready(function () {
            window.addEventListener('layananUpdated', function (event) {
                Swal.fire({
                    title: "Sukses!",
                    text: "Berhasil diperbarui!",
                    icon: "success",
                    timer: 1000,
                    timerProgressBar: true,
                });
            });
        })

    </script>

    {{-- Delete Modal --}}
    <script>
        $(document).ready(function () {

            // Membuka modal Delete
            window.addEventListener('show-delete-modal', function () {
                $('#modalDelete').modal('show');
            });

            // Mendengarkan event dari Livewire untuk menutup modal
            window.addEventListener('hide-delete-modal', function () {
                $('#modalDelete').modal('hide'); // Menutup modal

                // Menghapus backdrop ketika modal ditutup
                $('#modalDelete').on('hidden.bs.modal', function () {
                    $('body').removeClass('modal-open'); // Hilangkan kelas modal-open pada body
                    $('.modal-backdrop').remove(); // Hapus modal-backdrop
                });
            });

        });

    </script>

    {{-- Sweet alert,delete success --}}
    <script>
        $(document).ready(function () {
            window.addEventListener('deleteSuccess', function (event) {
                Swal.fire({
                    title: "Sukses!",
                    text: "Berhasil dihapus!",
                    icon: "success",
                    timer: 1000,
                    timerProgressBar: true,
                });
            });
        })

    </script>

    {{-- Sweet alert,error --}}
    <script>
        $(document).ready(function () {
            window.addEventListener('show-error', function (event) {
                Swal.fire({
                    title: "Oops!",
                    text: "Data tidak valid/sudah terhapus.",
                    icon: "error",
                    timer: 3000,
                    timerProgressBar: true,
                    showCloseButton: true,
                });
            });
        })

    </script>

    @endpush
</div>
