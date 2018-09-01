export default {
  mounted() {
    $(this.$options.static.elemento).tooltip();
  },
  methods: {
    $_TooltipMixin_ocultarTooltip() {
      $(this.$options.static.elemento).tooltip('hide');
    }
  }
};
