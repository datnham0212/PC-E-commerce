<?php
function renderBradcaump($title, $breadcrumbs, $backgroundImage = 'images/bg/2.jpg') {
    ?>
    <div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(<?php echo $backgroundImage; ?>) no-repeat scroll center center / cover ;">
        <div class="ht__bradcaump__wrap">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="bradcaump__inner text-center">
                            <h2 class="bradcaump-title"><?php echo $title; ?></h2>
                            <nav class="bradcaump-inner">
                                <?php
                                $lastIndex = count($breadcrumbs) - 1;
                                foreach ($breadcrumbs as $index => $crumb) {
                                    if ($index === $lastIndex) {
                                        echo '<span class="breadcrumb-item active">' . $crumb['text'] . '</span>';
                                    } else {
                                        echo '<a class="breadcrumb-item" href="' . $crumb['url'] . '">' . $crumb['text'] . '</a>';
                                        if ($index < $lastIndex - 1) {
                                            echo '<span class="brd-separetor">/</span>';
                                        }
                                    }
                                }
                                ?>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>