<template>
    <div id="NewsFlashes">
        <NavHeader></NavHeader>

        <Row type="flex" justify="center">
            <Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'container'">
                <Row type="flex" justify="space-between">
                    <Col :xs="{'span':16}" :sm="{'span':16}" :lg="{'span':16}">
                        <PageLeft>
                        </PageLeft>
                    </Col>
                    <Col :xs="{'span':7}" :sm="{'span':7}" :lg="{'span':7}" :class-name="'page-right'">
                        <PageRight :page-id="page_id">
                        </PageRight>
                    </Col>
                </Row>
            </Col>
        </Row>

        <FloatSideBar></FloatSideBar>
        <FooterArea></FooterArea>
    </div>
</template>

<script>
    import PageLeft from './7x24hLeft.vue';
    import PageRight from '../components/MainRight.vue';
    import NavHeader from '../components/NavHead.vue';
    import FooterArea from '../components/FooterArea.vue';
    import FloatSideBar from '../components/FloatSideBar.vue';

    export default {
        data() {
            return {
                page_id:6
            }
        },
        components: { PageLeft, PageRight, NavHeader, FooterArea, FloatSideBar }
    }
</script>

<style lang="scss" scoped>

    #NewsFlashes {
        .container{
            width:1200px;
            margin: 20px auto;
            min-height: 80vh;
        }
    }
</style>