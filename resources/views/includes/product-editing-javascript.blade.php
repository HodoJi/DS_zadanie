<script type="text/javascript">
    let jq = jQuery.noConflict();
    jq('#product_cost').on("keydown keyup", function(e){
        if (e.key === "e" || e.key === "-" || e.key === "+")
        {
            e.preventDefault();
        }
        else
        {
            let original_val = jq('#product_cost').data("original-value");
            let regex = /^(\d+|\d+[.,]\d|\d+[.,]\d{2})$/;

            if (this.value.length !== 0)
            {
                if (!regex.test(this.value))
                {
                    this.value = original_val;
                }
            }
        }
    });
</script>
