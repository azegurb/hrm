<div style="float: right">
    <ul class="breadcrumb" id="breadcrumb-ol">
        {{--@foreach($menus[1]->catalogs as $menu)--}}
            {{--@if($menu->uri=='personal-cards/changed-state-persons')--}}
                {{--<li class="breadcrumb-item"><a href="{{$menu->uri}}" rel="" class="getChangedUser btn btn-warning">{{$menu->title}}</a></li>--}}
            {{--@endif--}}
        {{--@endforeach--}}
    </ul>
</div>
<script src="/core/global/vendor/jquery/jquery.js"></script>

<script>

    $(document).ready(function () {

        $('body').on('click', '.getChangedUser', function (e) {

            e.preventDefault();

            $.ajax({
                method: 'GET',

                url: '/staff-table/changed-state-persons/',

                success: function (response) {


                },
                error: function (err) {

                    throw new Error('Error getting vacation days: ' + err);

                }
            });

        })
    })

</script>