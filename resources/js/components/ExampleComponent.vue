<script>
export default {
    data() {
        return {
            user: {},
            categories: [],
            cats: [],
            cities: [],
            product: {},
            images: [],
            src: null,
            selectedCategory: {},
            features: [],
            isSuccess: false,
            loading: true,
            priceArea: false,
            prefix: null,
            sub_features: []
        };
    },
    computed: {
        currency() {
            return this.product.price_currency;
        },
    },
    watch: {
        currency() {
            if (
                this.currency == "AZN" ||
                this.currency == "TL" ||
                this.currency == "RUB" ||
                this.currency == "$"
            ) {
                this.priceArea = true;
            } else {
                this.priceArea = false;
            }
        },
        prefix() {
            console.log(this.prefix);
            this.product.phone = this.prefix + " XXX XX XX";
        },
    },
    created() {
        this.$store.commit("pageLoader/set", true);
        let product_code = this.$route.query?.product_code;
        let urlString = "product/api/get/" + this.$route.params.id;

        if (typeof product_code != "undefined") {
            product_code = parseInt(product_code);
            urlString += "/" + product_code;
        }

        const cats = [...this.$store.getters['categories/all']]
        if (cats.length > 0) {
            this.cats = cats
            this.categories = this.formatedCategories(0)
        }


        window.axios
            .get(urlString)
            .then((res) => {
                if (res.data.user) {
                    this.user = res.data.user;
                }
                if (res.data.cities) {
                    this.cities = res.data.cities;
                }
                if (res.data.product) {
                    this.product = res.data.product;

                    const images = JSON.parse(this.product.images);
                    images.forEach((image) => {
                        this.images.push({
                            type: "orginal",
                            file: image,
                        });
                    });

                    this.selectedCategory = this.$store.getters[
                        "categories/get"
                        ](this.product.category_id);
                    const features = JSON.parse(this.selectedCategory.features);
                    const productFeatures = this.product.features;
                    const sub_features = this.product.features.filter(feature => feature.isSub == true)

                    features.forEach((feature) => {
                        const productFeature = productFeatures.find(
                            (F) => F.key == feature.name
                        );
                        const newFeature = {
                            name: feature.name,
                            value: "",
                        };
                        if (typeof productFeature != "undefined") {
                            newFeature.value = productFeature.value;
                            newFeature.id = productFeature.id;
                            newFeature.isSub = productFeature.isSub
                            if (feature.type == 'array') {
                                const subFeatureIndex = feature.value.findIndex(val => val.text == productFeature.value)
                                if (subFeatureIndex > -1) {
                                    const subFeature = feature.value[subFeatureIndex]
                                    const findIndex = this.sub_features.findIndex(sub_feature => sub_feature.parent_name == feature.name)
                                    if (findIndex > -1) {
                                        this.sub_features.splice(findIndex, 1)
                                    }
                                    if (subFeature.values) {
                                        const findSubIndex = sub_features.findIndex(sub_feature => sub_feature.key == subFeature.name)
                                        let val = ''
                                        if (findSubIndex > -1) {
                                            val = sub_features[findSubIndex].value
                                        }
                                        this.sub_features.push({
                                            ...subFeature,
                                            parent_name: feature.name,
                                            value: val
                                        })
                                    }
                                }
                            }
                        }
                        this.features.push(newFeature);
                    });
                }
            })
            .catch((err) => console.log(err.toString()))
            .finally(() => {
                this.loading = false;
                this.$store.commit("pageLoader/set", false);
            });
    },
    methods: {
        selectFile() {
            const allowedTypes = [
                "image/jpeg",
                "image/gif",
                "image/png",
                "image/webp",
            ];
            const fileMaxSize = 1024 * 1024 * 15; // 15 mb
            const files = Object.values(this.$refs.file.files);
            if (this.images.length + files.length > 8) {
                window.alertError("Max 8 ədəd şəkil yükləmək olar");
            } else {
                files.forEach((file) => {
                    if (!allowedTypes.includes(file.type)) {
                        window.alertError(
                            "Yalnız .jpeg, .jpg, .gif, .png, .webp formatlı fayllardan birini yükləyə bilərsiniz"
                        );
                    } else if (file.size > fileMaxSize) {
                        window.alertError(
                            "15 mb-dan artıq ölçülü fayl yükləyə bilməzsiniz"
                        );
                    } else {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            const src = e.target.result;
                            this.images.push({
                                type: "new",
                                file: file,
                                src: src,
                            });
                        };
                        if (typeof file != "undefined") {
                            reader.readAsDataURL(file);
                        }
                    }
                });
            }
        },
        removeImage(index) {
            this.images.splice(index, 1);
        },
        edit() {
            if (this.images.length > 0) {
                this.$store.commit("pageLoader/set", true);
                if (this.sub_features.length > 0) {
                    this.sub_features.forEach(sub_feature => {
                        this.features.push({
                            name: sub_feature.name,
                            value: sub_feature.value,
                            isSub: true
                        })
                    })
                }

                const formData = new FormData();
                formData.append("id", this.product.id);
                formData.append("title", this.product.title);
                formData.append("description", this.product.description);
                if (this.priceArea) {
                    formData.append("price", this.product.price);
                }
                formData.append("price_currency", this.product.price_currency);
                formData.append("city", this.product.city);
                formData.append("product_code", this.product.product_code);
                formData.append("email", this.product.email);
                formData.append("user_name", this.product.user_name);
                formData.append("phone", this.product.phone);
                formData.append("features", JSON.stringify(this.features));
                let i = 0;
                const images = this.images;
                const orginalImages = images.filter(
                    (image) => image.type == "orginal"
                );
                const newImages = images.filter((image) => image.type == "new");
                formData.append("orginalImages", JSON.stringify(orginalImages));

                newImages.forEach((item) => {
                    i++;
                    formData.append("files[" + i + "]", item.file);
                });

                window.axios
                    .post("product/api/save", formData, {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                    })
                    .then((res) => {
                        if (res.data.success) {
                            this.isSuccess = true;
                            window.alert.success(res.data.success);
                        } else if (res.data.error) {
                            window.alertError(res.data.error);
                        }
                    })
                    .catch((err) => window.alertError(err.toString()))
                    .finally(() => this.$store.commit("pageLoader/set", false));
            } else {
                window.alertError("Elan şəkli seçilmədi");
            }
        },
        formatedCategories(parent_id) {
            let categories = this.cats.filter(category => category.parent_id == parent_id)
            categories.forEach(category => {
                category.children = this.formatedCategories(category.id)
            })
            return categories
        },
        selectFeature(index) {
            const selectedFeature = this.features[index]
            const features = JSON.parse(this.selectedCategory.features);
            const feature = features[index]
            if (feature.name == selectedFeature.name) {
                const subFeatureIndex = feature.value.findIndex(val => val.text == selectedFeature.value)
                if (subFeatureIndex > -1) {
                    const subFeature = feature.value[subFeatureIndex]
                    const findIndex = this.sub_features.findIndex(sub_feature => sub_feature.parent_name == feature.name)
                    if (findIndex > -1) {
                        this.sub_features.splice(findIndex, 1)
                    }
                    if (subFeature.values && subFeature.values.length > 0) {
                        this.sub_features.push({
                            ...subFeature,
                            parent_name: feature.name,
                            value: ''
                        })
                    }
                }
            }
        }
    },
};
</script>
<template>
    <div>
        <div v-if="$_.isEmpty(product) && !loading" class="alert alert-danger">
            Elan tapılmadı
        </div>
        <form v-else-if="!loading" id="form" @submit.prevent="edit">
            <fieldset class="s1">
                <div class="in">
                    <!-- CATEGORY -->

                    <div id="category-picker" class="cat-picker picker-v2">
                        <label for="term3"
                        ><span>Kateqoriya seç</span>
                            <span class="req">*</span></label
                        >
                        <div class="mini-box">
                            <select
                                v-if="categories.length > 0"
                                v-model="product.category_id"
                                class="form-control"
                                disabled
                            >
                                <optgroup
                                    v-for="(
                                        category, categoryIndex
                                    ) in categories"
                                    :key="'categoryIndex-' + categoryIndex"
                                    :label="category.name"
                                >
                                    <option
                                        v-for="(
                                            child, childIndex
                                        ) in category.children"
                                        :key="'childIndex-' + childIndex"
                                        :value="child.id"
                                    >
                                        {{ child.name }}
                                    </option>
                                </optgroup>
                            </select>
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset v-if="!this.$_.isEmpty(selectedCategory)" class="s6">
                <div class="in">
                    <div
                        v-for="(feature, index) in JSON.parse(
                            selectedCategory.features
                        )"
                        :key="index"
                        class="form-group"
                    >
                        <label
                        >{{ feature.name }}
                            <span v-if="feature.required">*</span></label
                        >
                        <select
                            v-if="feature.type == 'array'"
                            v-model="features[index].value"
                            class="form-control"
                            @change="selectFeature(index)"
                            :required="feature.required"
                        >
                            <option
                                v-for="value in feature.value"
                                :value="value.text"
                            >
                                {{ value.text }}
                            </option>
                        </select>
                        <input
                            v-if="feature.type == 'string'"
                            v-model="features[index].value"
                            type="text"
                            class="form-control"
                            :placeholder="feature.name"
                            :required="feature.required"
                        />
                        <input
                            v-if="feature.type == 'number'"
                            v-model="features[index].value"
                            type="number"
                            min="0"
                            class="form-control"
                            :placeholder="feature.name"
                            :required="feature.required"
                        />
                        <div v-if="feature.type == 'radio'">
                            <div
                                v-for="(value, indexR) in feature.value"
                                class="custom-control custom-radio custom-control-inline mb-3"
                            >
                                <input
                                    type="radio"
                                    :name="feature.name"
                                    :value="value.text"
                                    :id="feature.name + '-' + (index + indexR)"
                                    v-model="features[index].value"
                                    class="custom-control-input"
                                    :required="feature.required"
                                />
                                <label
                                    class="custom-control-label"
                                    :for="feature.name + '-' + (index + indexR)"
                                >{{ value.text }}</label
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset v-if="sub_features.length != 0" class="s7">
                <div class="in">
                    <div
                        v-for="(subFeature, subFeatureIndex) in sub_features"
                        :key="'subFeatureIndex-'+subFeatureIndex"
                        class="form-group"
                    >
                        <label>{{ subFeature.name }} <span>*</span></label>
                        <select v-model="subFeature.value"
                                class="form-control"
                                required>
                            <option
                                v-for="value in subFeature.values"
                                :value="value.text">
                                {{ value.text }}
                            </option>
                        </select>
                    </div>
                </div>
            </fieldset>
            <fieldset class="s2">
                <div class="in">
                    <div class="loc-picker picker-v2 ctr-more">
                        <label for="term2"
                        ><span>Şəhər seç</span>
                            <span class="req">*</span></label
                        >

                        <select
                            v-if="cities.length > 0"
                            v-model="product.city"
                            class="form-control"
                        >
                            <option
                                v-for="(city, cityIndex) in cities"
                                :key="'cityIndex-' + cityIndex"
                                :value="city.id"
                            >
                                {{ city.name }}
                            </option>
                        </select>
                    </div>
                </div>
            </fieldset>
            <fieldset class="s3">
                <div class="in">
                    <div class="loc-picker picker-v2 ctr-more">
                        <label for="term2"
                        ><span>Ad</span><span class="req">*</span></label
                        >
                        <input
                            type="text"
                            v-model="product.user_name"
                            class="form-control"
                            required
                        />
                    </div>
                    <label for="term2"
                    ><span>Nömrə</span><span class="req">*</span></label
                    >
                    <select
                        id="selectPrefix"
                        class="form-control col-sm-4"
                        v-model="prefix"
                    >
                        <option value="" disabled>Prefiks seçin</option>
                        <option value="+99450">050</option>
                        <option value="+99451">051</option>
                        <option value="+99455">055</option>
                        <option value="+99499">099</option>
                        <option value="+99470">070</option>
                        <option value="+99477">077</option>
                        <option value="+99460">066</option>
                        <option value="012">012</option>
                    </select>
                    <br/>
                    <div class="loc-picker picker-v2 ctr-more">
                        <input
                            id="phone"
                            type="text"
                            v-model="product.phone"
                            class="form-control"
                            required
                        />
                    </div>
                    <br/>
                    <div class="loc-picker picker-v2 ctr-more">
                        <label for="term2"
                        ><span>Email</span><span class="req">*</span></label
                        >
                        <input
                            type="email"
                            v-model="product.email"
                            class="form-control"
                            required
                        />
                    </div>
                    <br/>
                </div>
            </fieldset>
            <fieldset class="s4">
                <div class="in">
                    <!--Qiymət -->

                    <div class="loc-picker picker-v2 ctr-more">
                        <label for="term2"
                        ><span>Qiymət</span
                        ><span class="req">*</span></label
                        >
                        <select
                            id="selectCurrency"
                            class="form-control col-sm-4"
                            v-model="product.price_currency"
                            autocomplete="off"
                        >
                            <option value="Pulsuz">Pulsuz</option>
                            <option value="Razılaşma">Razılaşma</option>
                            <option id="azn" value="AZN">AZN</option>
                            <option value="TL">TL</option>
                            <option value="RUB">RUB</option>
                            <option value="$">USD</option>
                        </select>
                        <br/>
                        <input
                            id="price"
                            v-if="priceArea"
                            type="number"
                            min="1"
                            v-model="product.price"
                            class="form-control"
                        />
                    </div>
                </div>
            </fieldset>
            <fieldset class="s5">
                <div class="in">
                    <!-- TITLE & DESCRIPTION -->
                    <div class="title-desc-box">
                        <div class="row">
                            <div class="tabber">
                                <div class="tabbertab">
                                    <div class="title">
                                        <div>
                                            <label for="title">Başlıq *</label>
                                        </div>
                                        <input
                                            type="text"
                                            v-model="product.title"
                                            required
                                        />
                                    </div>
                                    <div class="description">
                                        <div>
                                            <label for="description"
                                            >Haqqında *</label
                                            >
                                        </div>
                                        <textarea
                                            v-model="product.description"
                                            rows="10"
                                            required
                                        ></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset class="photos">
                <div class="in">
                    <!--Images -->
                    <div class="loc-picker picker-v2 ctr-more">
                        <label for="term2"
                        ><span>Şəkil (max: 8)</span
                        ><span class="req">*</span></label
                        >

                        <input
                            type="file"
                            id="upload-ad-image"
                            ref="file"
                            accept="image/*"
                            v-on:change="selectFile"
                            class="form-control"
                            multiple
                        />
                        <br/>

                        <div id="preview-images" class="d-flex flex-row">
                            <div
                                v-for="(image, index) in images"
                                class="preview-image"
                                :key="'image-' + index"
                                v-dragging="{
                                    item: image,
                                    list: images,
                                    group: 'image',
                                }"
                            >
                                <img
                                    v-if="image.type == 'orginal'"
                                    :src="'/uploads/products/' + image.file"
                                    alt=""
                                />
                                <img
                                    v-else-if="image.type == 'new'"
                                    :src="image.src"
                                    alt=""
                                />
                                <a
                                    @click.prevent="removeImage(index)"
                                    class="remove-preview-image"
                                    href="#"
                                >
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
            <div class="buttons-block">
                <div class="inside">
                    <div class="box">
                        <div class="row">
                            <div id="anr_captcha_field_1"></div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <button type="submit" class="btn mbBg">Yadda saxla</button>
                </div>
            </div>
        </form>
    </div>
</template>
<style>
.preview-image {
    display: flex;
    position: relative;
    margin: 5px;
}

.preview-image .rotate-preview-image {
    position: absolute;
    top: 10px;
    left: 10px;
}

.preview-image .remove-preview-image {
    position: absolute;
    top: 10px;
    right: 10px;
}
</style>
