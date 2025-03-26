jQuery.validator.addMethod("domain", function(value, element) {
    return this.optional(element) || /^http:\/\/mycorporatedomain.com/.test(value);
  }, "
