<template>
	<Row v-if="loading">
	    <Col class="demo-spin-col" :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'span':8,'offset':8}">
	        <Spin fix>
	            <Icon type="load-c" size=18 class="demo-spin-icon-load"></Icon>
	            <div>Loading</div>
	        </Spin>
	    </Col>
	</Row>	
</template>
<script>
	export default{
		name: 'Loading',
		props:['loading']
	}
</script>