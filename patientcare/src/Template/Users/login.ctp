<div  class="index large-4 medium-4 large-offset-4 medium-offset-4 columns content" >

<div class="panel">
<h3 class="text-center" > PatientCare Admin Login</h3>
<?= $this->Form->create(); ?>
<?= $this->Form->input('email'); ?>

<?= $this->Form->ipnut('password' , array('type' => 'password')) ; ?>
<?= $this->Form->submit('Login' , array('class' => 'button')); ?>

<?= $this->Form->end();?>
</div>
</div>
