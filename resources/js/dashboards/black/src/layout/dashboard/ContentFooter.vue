<template>
  <footer class="footer" dir="rtl">
    <div class="container-fluid">
      <ul class="nav">
        <li class="nav-item">
          <a class="nav-link" href="http://www.creative-tim.com">
            SmaaT
          </a>
        </li>
      </ul>
      <div class="copyright">
        © 2017 - {{year}} طراحی و توسعه <i class="tim-icons icon-heart-2"></i> توسط
        <a href="https://www.smaat.ir" target="_blank" rel="noopener">SmaaT Co</a>
      </div>
    </div>
  </footer>
</template>

<script>
  export default {
    data() {
      return {
        year: new Date().getFullYear()
      }
    },
    created() {
      setTimeout(() => {
        $('footer.footer').slideDown();
      }, 1000);
    }
  };
</script>

<style scoped>

footer {
  display: none;
}

</style>

