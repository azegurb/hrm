<section id="links">
    <link rel="stylesheet" href="{{asset('core/global/vendor/toastr/toastr.css')}}">
    <link rel="stylesheet" href="{{asset('core/global/vendor/jstree/jstree.min.css')}}">
</section>

<section id="content">
    <div class="panel">
        <div class="panel-body pt-20">

            <div class="row">

                {{--Filters--}}
                <div class="col-md-3 pull-l mb-10 pl-0">
                    <div class="input-search">
                        <button type="submit" class="input-search-btn">
                            <div class="loader vertical-align-middle loader-circle search-loader"></div>
                        </button>
                        <input type="text" class="form-control" name="region-search" id="region-search"
                               placeholder="Axtar...">
                    </div>
                </div>
                {{--End Filters--}}

            </div>

            <div class="row mt-20">
                <div class="col-md-12 p-0">
                    <div id="regions-tree">

                    </div>
                </div>
            </div>

            <div class="site-action" data-plugin="animateList" data-animate="fade" data-child="button"
                 data-selectable="selectable">
                <button id="addToTable" class="btn btn-floating btn-info waves-effect" data-target="#regions-modal"
                        data-toggle="modal" type="button">
                    <i class="icon md-plus" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </div>
    {{-- Modal --}}
    @include('pages.helper_lists.regions._modal')
    {{-- /Modal --}}
</section>

<section id="scripts">
    <script src="{{asset('core/global/vendor/toastr/toastr.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/custom/pages/work-experience/modal.js')}}"></script>
    <script src="{{asset('core/global/vendor/jstree/jstree.min.js')}}"></script>

    <script type="text/javascript">
        // error toastr
        @if(session()->has('message'))
            if ('{{session()->get('message')['type']}}' === 'error')
            {
                toastr.error('{{session()->get('message')['data']}}', '<b>Diqqət!</b>'); // Display error toast, with a title
            }
            else
            {
                toastr.success('{{session()->get('message')['data']}}', '<b>Diqqət!</b>'); // Display success toast, with a title
            }
            @php session()->forget('message') @endphp
        @endif
        /** js tree */
        let tree = $('#regions-tree');
        /** regions data */
        let regions = {!! $regions !!};
        /** optios with data merged */
        let options = {
            'core' : {
                'data' : regions,
                'check_callback' : false,
                'animation' : 1
            },
            'plugins' : [
                'wholerow', 'contextmenu'
            ],
            'contextmenu': {
                'items' : {
                    'edit' : {
                        'separator_before'	: false,
                        'separator_after'	: false,
                        '_disabled'			: false,
                        'label'				: 'Dəyişdir',
                        'action'			: function (data) {
                            let inst = $.jstree.reference(data.reference),
                                obj  = inst.get_node(data.reference);
                            openModal('/helper-lists/regions/'+obj.id+'/edit', 'regions-modal');
                        }
                    },
                    'remove' : {
                        'separator_before'	: false,
                        'icon'				: false,
                        'separator_after'	: false,
                        'label'				: 'Sil',
                        '_disabled'         : function(data) {
                            let inst = $.jstree.reference(data.reference),
                                obj  = inst.get_node(data.reference);

                            return obj.children.length !== 0;
                        },
                        'action'			: function (data) {
                            let inst = $.jstree.reference(data.reference),
                                obj  = inst.get_node(data.reference);

                            swal({
                                title: "Bu faylı silməyə razısınız?",
                                html: html,
                                text: '',
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#DD6B55",
                                confirmButtonText: "Təsdiq",
                                cancelButtonText: "İmtina",
                                closeOnConfirm: false
                            }, function(confirm) {

                                if (confirm) {

                                    $.ajax({
                                        // Get Remote data
                                        url: '/helper-lists/regions/'+obj.id,
                                        type: 'DELETE',
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        timeout: 30000,
                                        async: true,
                                        success: function (response) {

                                            if (response.code == 200) {
                                                tree.jstree(true).settings.core.data = response.data;
                                                tree.jstree(true).refresh();
                                                swal(
                                                    'Silindi!',
                                                    response.message,
                                                    'success'
                                                );
                                            } else {
                                                toastr.error(response.message, '<b>Diqqət!</b>');
                                            }
                                        }
                                    });

                                }

                            });

                        }
                    }
                }
            }
        };
        /** defaults */
        $.jstree.defaults.core.themes.variant = 'large';
        /** initialize bs-tree */
        tree.jstree(options);
    </script>

</section>