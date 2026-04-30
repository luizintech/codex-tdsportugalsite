<div class="row">
    <div class="col-md-7 col-xs-12">
        <div class="row">
            @include("Posts/edit-form")
        </div>
    </div>
    <div class="col-md-5 col-xs-12">
        <div class="row">
            <div class="col-md-12 form-group">
                <label class="control-label">Mídia de capa:</label>
                <div class="d-flex gap-2 align-items-center">
                    <input type="hidden" name="cover_media_id" id="cover_media_id" value="{{ $viewModel->selectedMediaId ?? '' }}">
                    <input type="text" id="cover_media_name" class="form-control" readonly
                        value="{{ optional(collect($viewModel->medias)->firstWhere('id', $viewModel->selectedMediaId))->filename }}">
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#mediaPickerModal">Escolher mídia</button>
                </div>
            </div>

            <div class="modal fade" id="mediaPickerModal" tabindex="-1" aria-labelledby="mediaPickerModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="mediaPickerModalLabel">Selecionar mídia de capa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" id="media-search" class="form-control mb-3" placeholder="Pesquisar por filename, path ou slug..." />
                        <div class="table-responsive" style="max-height: 350px; overflow-y: auto;">
                        <table class="table table-striped" id="media-picker-table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Arquivo</th>
                                <th>Path</th>
                                <th>Slug</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($viewModel->medias as $media)
                                <tr>
                                <td>{{$media->id}}</td>
                                <td>{{$media->filename}}</td>
                                <td>{{$media->path}}</td>
                                <td>{{$media->slug}}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary choose-media"
                                    data-id="{{$media->id}}" data-name="{{$media->filename}}">Selecionar</button>
                                </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        </div>
                    </div>
                    </div>
                </div>
                </div>

            <div class="col-md-12 form-group">
                <label class="control-label">Labels:</label>
                <select name="label_ids[]" class="form-control select2" multiple>
                    @foreach($viewModel->labels as $label)
                        <option value="{{$label->id}}" {{ in_array($label->id, $viewModel->selectedLabels ?? []) ? 'selected' : '' }}>{{$label->title}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-12 form-group">
                <label class="control-label">Categorias:</label>
                <select name="category_ids[]" class="form-control select2" multiple>
                    @foreach($viewModel->categories as $category)
                        <option value="{{$category->id}}" {{ in_array($category->id, $viewModel->selectedCategories ?? []) ? 'selected' : '' }}>{{$category->title}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>