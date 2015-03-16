<div class="container">
    <br>
    <br>
    <br>
    <?=flash();?>
    <div class="row login-form">
        <h4>Ajouter une nouvelle realisation</h4>
        <div class="col-sm-8">
            <form action="#" method="POST" enctype="multipart/form-data">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="name">Nom du la resalisation :</label>
                        <?=input('name');?>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="slug">URL de la realisation :</label>
                        <?=input('slug');?>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="categoty_id">La categorie :</label>
                        <?=selectInput('category_id', $categories_list);?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="slug">Le Contenu du la realisation :</label>
                    <?=input('content', 'textarea');?>
                </div>
                <div class="form-group">
                    <?=input('work_images[]', 'file');?>
                    <input type="file" name="work_images[]"class="hidden form-control" id="copyinput">
                </div>
                <div class="form-group">
                    <p><a href="#" class="btn btn-success" id="copybtn">Ajouter une image</a></p>
                    <button type="submit" class="btn btn-default">Enregestrer</button>
                </div>
            </form>
        </div>
        <div class="col-sm-4">
            <?php foreach ($images as $key => $image): ?>
            <div class="col-xs-4 thumbnail">
                <img src="<?=WEB_ROOT . "works/images/" . $image['name'];?>" alt="Photo de realisation" width='125' height='125'>
                <ul class="pager">
                    <li>
                        <a href="?delete_image=<?=$image['id'] . "&" . CSRF()?>" onclick= "return confirm('Vous voulez vraimment de supprimer l\'image')">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true" class="previous"></span>
                        </a>
                    </li>
                    <li>
                        <a href="?highlight_image=<?=$image['id'] . '&id=' . $_GET['id'] . "&" . CSRF();?>"><span class="glyphicon glyphicon-bookmark" aria-hidden="true" class="next"></span></a>
                    </li>
                </ul>
            </div>
            <?php endforeach;?>
        </div>
    </div>
</div>

<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>
(function($){
$('#copybtn').click(function(e) {
e.preventDefault();
var $clone = $('#copyinput').clone().attr('id', '').removeClass('hidden');
$('#copyinput').before($clone);
});
})(jQuery);
$(alert-success).delay(20).slideUp(20);
tinymce.init({selector:'textarea'});
</script>
