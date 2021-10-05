<template>
<div></div>
    <!-- <div>
        <h1>Create</h1>
        <div class="container">
            <form @submit="checkForm" action="" method="post">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Email address</label>
                    <input
                        type="email"
                        class="form-control"
                        id="exampleFormControlInput1"
                        placeholder="name@example.com"
                    />
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1"
                        >Example select</label
                    >
                    <select class="form-control" id="exampleFormControlSelect1">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect2"
                        >Example multiple select</label
                    >
                    <select
                        multiple
                        class="form-control"
                        id="exampleFormControlSelect2"
                    >
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1"
                        >Example textarea</label
                    >
                    <textarea
                        class="form-control"
                        id="exampleFormControlTextarea1"
                        rows="3"
                    ></textarea>
                </div>
            </form>
        </div>
    </div> -->
</template>

<script>
export default {
    name: "Create",

    data() {
        return {
            services: []
        };
    },

    mounted() {
        console.log("Component mounted.");

        axios
            .get("/api/apartment/create")
            .then(response => {
                this.services = response.data.results;
                console.log(this.services);
            })
            .catch(error => {
                console.log(error);
            });
    },

    // methods: {
    //     checkForm: function(e) {
    //         if (this.name && this.age) {
    //             return true;
    //         }

    //         this.errors = [];

    //         if (!this.name) {
    //             this.errors.push("Name required.");
    //         }
    //         if (!this.age) {
    //             this.errors.push("Age required.");
    //         }

    //         e.preventDefault();
    //     }
    // }
};
</script>
