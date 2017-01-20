<ul class='pagination'>
    <?php if ($this->current_page != 1 && $this->current_page != 2) { ?>
    <li><a href="<?=$this->current_section ?><?php echo $this->current_page - 1 ?>">&laquo;</a></li>
    <?php } ?>
    <?php if ($this->current_page == 2) { ?>
        <li><a href="<?=$this->current_section_short ?>">&laquo;</a></li>
    <?php } ?>
    <?php if ($this->current_page - 2 > 1) {?>
        <li><a href="<?=$this->current_section_short ?>">1</a></li>
        <li>...</li>
    <?php } ?>
    <?php for ($i = $this->current_page - 2; $i < $this->current_page + 3; $i++) { ?>
        <?php if ($i < 1 || $i > $this->pagination_pages) continue; ?>
        <li><a <?php if ($i == $this->current_page) echo "class='this-page'" ?> href="<?php if ($i == 1) echo $this->current_section_short; else echo $this->current_section.$i ?>"><?=$i ?></a></li>
    <?php } ?>
    <?php if ($this->current_page + 2 < $this->pagination_pages) { ?>
        <li>...</li>
        <li><a href="<?=$this->current_section.$this->pagination_pages ?>"><?=$this->pagination_pages ?></a></li>
    <?php } ?>
    <?php if ($this->current_page != $this->pagination_pages) { ?>
        <li><a href="<?=$this->current_section ?><?php echo $this->current_page + 1?>">&raquo;</a></li>
    <?php } ?>
</ul>