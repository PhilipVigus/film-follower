<div
    x-data="{
        observer: null,
        observe () {
            this.observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        $parent.filmsShowing += $parent.filmsPerSlice;
                        this.observer.unobserve(entry.target);
                    }
                })
            }, {
                root: null
            })

            if ((parseInt(this.$el.parentNode.getAttribute('index')) + 10) % 10 === 0) {
                this.observer.observe(this.$el);
            }
        }
    }"
    x-init="observe()"
></div> 
