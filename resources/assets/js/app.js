
import Vue from 'vue';

// register pages
import cargoMtRpt from './pages/cargo_mt_rpt.vue';
import cargoLooseMtRpt from './pages/cargo_loose_mt_rpt.vue';
import cargoContainerizedMtRpt from './pages/cargo_containerized_mt_rpt.vue';
import totalTeusRpt from './pages/total_teus_rpt.vue';
import totalContainersRpt from './pages/total_containers_rpt.vue';
import totalVesselRpt from './pages/total_vessel_rpt.vue';
import vesselTop from './pages/vessel_top_rpt.vue';
import agentTop from './pages/agent_top_rpt.vue';

// register components
import horizontalbar from './components/graph/horizontalbar.vue';
import horizontalbar2 from './components/graph/horizontalbar2.vue';
import bar2 from './components/graph/bar2.vue';
import bar from './components/graph/bar.vue';

new Vue({
	el: 'body',

	components: {
		cargoMtRpt, cargoLooseMtRpt, cargoContainerizedMtRpt, totalTeusRpt, totalContainersRpt, totalVesselRpt, vesselTop, agentTop,
		bar, bar2, horizontalbar, horizontalbar2
	}
});