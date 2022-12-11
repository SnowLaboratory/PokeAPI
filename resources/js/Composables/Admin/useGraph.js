import { computed, isRef, onMounted, reactive, ref, toRef, unref } from 'vue';
import { useHook } from './useHook';

const nextId = ref(1)

export const useGraph = (settings) => {
    const { hook } = useHook('useGraph', settings);

    const nodes = ref({})
    const edges = ref({})
    const selectedNode = ref(null)

    const setAllNodeMeta = (key, value) => {
        for (let id in nodes.value) {
            setNodeMeta(id, key, value)
        }
    }

    const setNodeMeta = (nodeId, key, value) => {
        _.set(nodes.value[nodeId], ['meta', key], value);
    }

    const setAllEdgeMeta = (key, value) => {
        for (let id in edges.value) {
            setEdgeMeta(id, key, value)
        }
    }

    const setEdgeMeta = (edgeId, key, value) => {
        _.set(edges.value[edgeId], ['meta', key], value);
    }

    const selectNode = (nodeId) => {
        setAllNodeMeta('selected', false)
        setNodeMeta(nodeId, 'selected', true)
        selectedNode.value = nodes.value[nodeId]
    }

    const createDataAttributes = () => {
        return {
            meta: {
                selected: true
            },
            data: {},
        }
    }

    const createNode = (id, x, y) => {
        return {
            id,
            position: { x, y },
            ...createDataAttributes(),
        }
    }

    const addNode = (x, y) => {
        const id = nextId.value++
        const node = createNode(id, x, y)
        nodes.value = {
            ...nodes.value,
            [id]: node
        }
        selectNode(id)
        return node;
    }

    const removeNode = (id) => {
        delete nodes[id]
    }

    const linkNodes = (parent, child) => {
        const id = nextId.value++

        const edge = {
            id,
            parent,
            child,
            ...createDataAttributes(),
        }

        edges.value = {
            ...edges.value,
            [id]: edge
        }
        return edge
    }

    const removeLink = (id) => {
        delete edges.value[id]
    }

    return {
        get nodes () {
            return nodes.value
        },
        get edges () {
            return edges.value
        },
        get selectedNode () {
            return selectedNode.value
        },
        addNode,
        selectNode,
        linkNodes,
    }
}
