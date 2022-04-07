<div class="tree-container-custom " id="tree-container-show">
    <div id="element" class="container pr-30 scroll">
        <div class="row mt-5 tree-radio">
            <div class="radio-custom radio-primary float-left mr-30">
                <input type="radio" id="current" checked name="bt">
                <label for="current">Cari</label>
            </div>
            <div class="radio-custom radio-primary float-left pl-15 mr-15">
                <input type="radio" id="archive" class="pl-5" name="bt">
                <label for="archive">Arxiv</label>
            </div>

        </div>
        <div>
            <button type="button" class="btn btn-primary waves-effect waves-light" id="treeModalButton"><i class="icon md-plus" aria-hidden="true"></i> Yeni</button>
        </div>
        <div id="js-tree" class="mt-25"></div>
    </div>
    <button class="tree-btn" id="tree-btn"><i class="icon md-more-vert" aria-hidden="true"></i></button>
</div>
<script type="text/javascript">
    var element = document.getElementById('tree-container-show');
    var resizer = document.createElement('div');
    resizer.className = 'resizer';
    resizer.style.width = '5px';
    resizer.style.height = '100vh';
    resizer.style.background = 'transparent';
    resizer.style.position = 'absolute';
    resizer.style.right = 0;
    resizer.style.bottom = 0;
    resizer.style.cursor = 'e-resize';
    element.style.minWidth = '350px';
    element.style.maxWidth = '650px';
    element.appendChild(resizer);
    resizer.addEventListener('mousedown', initResize, true);

    function initResize(e) {
        window.addEventListener('mousemove', Resize, false);
        window.addEventListener('mouseup', stopResize, false);
    }
    function Resize(e) {
        element.style.width = (e.clientX - element.offsetLeft) + 'px';
    }
    function stopResize(e) {
        window.removeEventListener('mousemove', Resize, false);
        window.removeEventListener('mouseup', stopResize, false);
    }


</script>