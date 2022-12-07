import { isRef, onMounted, reactive, ref, toRef, unref } from 'vue';

export const useGraph = (settings) => {

    const edges = isRef(settings.edges)
                    ? settings.edges
                    : ref(settings.edges);

    const selectingNode = ref(false)
    const selectedNode = ref(null);
    const newIdCounter = ref(settings.startingId ?? 1);

    const invoke = (key, ...args) => {
        if (typeof settings[key] === 'function') {
            return settings[key](...args)
        }
    }

    const stopped = (key, ...args) => {
        return invoke(key, ...args) === false;
    }

    const createNode = (x, y, options = {}) => {
        if (stopped('beforeCreateNode', x,y,options)) return
        edges.value.push({
            p1: {
                x,y,
                id: newIdCounter.value++,
                data: {
                    selected: false
                },
                // ...options
            },
            p2: null
        })
        invoke('afterCreateNode', edges.value[edges.value.length - 1].p1)
        return edges.value[edges.value.length - 1].p1
    }

    const selectNode = (node) => {
        if (stopped('beforeSelect', node)) return
        selectedNode.value = node;
        selectingNode.value = true;

        edges.value.forEach(edge => {
            _.set(edge.p1 ?? {}, 'data.selected', false)
            _.set(edge.p2 ?? {}, 'data.selected', false)
        })

        if (isRef(node.data)) {
            node.data.value.selected = !node.data.value.selected
        } else {
            node.data.selected = !node.data.selected
        }
        if (stopped('afterSelect', node)) return
    }

    const handleAreaClick = (e) => {
        if (stopped('beforeAreaClick', e)) return

        if (selectingNode.value) {
            e.preventDefault();
            selectingNode.value = false
            return;
        }

        const node = createNode(e.layerX - 24, e.layerY - 24)
        console.log(node)
        selectNode(node)
        selectingNode.value = false
        if (stopped('afterAreaClick', e)) return
    }

    const linkNodes = (p1, p2) => {
        if (stopped('beforeLinkNodes', p1, p2)) return

        // const filter = x => (
        //     // !x.p2 && !x.p1.data.selected && (x.p1.id == p1.id || x.p1.id == p2.id)

        // )

        // edges.value = _.reject(edges.value, filter)

        // console.log('asdf', selectedNode.value.id, p1.id, p2.id)

        if (selectedNode.value.id === p1.id) {
            const local = x => (
                !x.p2 && x.p1.id == p1.id
            )
            const foreign = x => (
                !x.p2 && x.p1.id == p2.id
            )

            const e1 = edges.value.find(local);

            if (!e1) {
                const e2 = edges.value.find(foreign)
                e2.p2 = e2.p1
                e2.p1 = p1
                // console.log(e2, selectedNode.value)
                // const n1 = edges.value.find(local).p1;
            } else {
                const n2 = edges.value.find(foreign).p1;
                e1.p2 = n2
                _.remove(edges.value, foreign)
            }



            // edges.value.filter(filter).map(
            //     x => {
            //         x.p2 = p1
            //         return x
            //     }
            // )
            // console.log(edges.value.filter(filter))
        }

        // edges.value.push({p1, p2, data:{}})

        if (stopped('afterLinkNodes', p1, p2)) return
    }

    const handleShiftClick = (e) => {
        if (selectedNode.value) {

            if (stopped('beforeShiftClick', e)) return
            selectingNode.value = false
            const node = createNode(e.layerX - 24, e.layerY - 24)
            setTimeout(() => {
                linkNodes(selectedNode.value, node)
                selectNode(node)
                selectingNode.value = false
                if (stopped('afterShiftClick', selectedNode, node)) return
            }, 1)
        }
    }

    const handleSelectedNode = (e) => {
        if (stopped('beforeSelectNode', e)) return
        selectNode(e.$node)
        if (stopped('afterSelectNode', e.$node)) return
    }

    const handleSecondSelection = (e) => {
        if (stopped('beforeSelect2', e)) return
        console.log('2nd selection', e.$node, selectedNode.value)
        linkNodes(selectedNode.value, e.$node)
        selectNode(e.$node)
        selectingNode.value = false
        if (stopped('afterSelect2', e.$node)) return
    }

    const dataModel = (value, key) => {
        if (selectedNode.value) {
            _.set(selectedNode.value, ['data', key], value)
        }
    }

    return reactive({
        // return event listeners
        createNode,
        selectNode,
        handleAreaClick,
        linkNodes,
        handleShiftClick,
        handleSelectedNode,
        handleSecondSelection,
        edges,
        selectNode,
        selectedNode,
        selectingNode,
        newIdCounter,
        dataModel
    })
}
