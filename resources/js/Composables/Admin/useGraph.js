import { computed, isRef, onMounted, reactive, ref, toRef, unref } from 'vue';
import { useHook } from './useHook';

const nextId = ref(1)

export const useGraph = (settings) => {
    const { hook } = useHook('useGraph', settings);

    const nodes = isRef(settings.nodes)
                    ? settings.nodes
                    : ref(settings.nodes);

    const edges = isRef(settings.edges)
                    ? settings.edges
                    : ref(settings.edges);

    nextId.value += Object.keys(nodes.value ?? {}).length + Object.keys(edges.value ?? {}).length

    const selectedNode = ref(null)

    const selectedEdge = ref(null)

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

    const nodeModel = (value, key) => {
        if (selectedNode.value) {
            _.set(selectedNode.value, ['data', key], value)
        }
    }

    const edgeModel = (value, key) => {
        if (selectedEdge.value) {
            _.set(selectedEdge.value, ['data', key], value)
        }
    }

    const selectNode = (nodeId) => {
        return hook('SelectNode', (resolve) => {
            selectedEdge.value = null
            selectedNode.value = nodes.value[nodeId]
            resolve()
        }, [nodeId])
    }

    const selectEdge = (edgeId) => {
        return hook('SelectEdge', (resolve) => {
            selectedNode.value = null
            selectedEdge.value = edges.value[edgeId]
            resolve()
        }, [edgeId])
    }

    const createDataAttributes = () => {
        return {
            meta: {},
            data: {},
        }
    }

    const createNode = (id, x, y) => {
        return hook('CreateNode', (resolve) => {
            return resolve({
                id,
                position: { x, y },
                ...createDataAttributes(),
            })
        }, [id, x, y])
    }

    const addNode = (x, y) => {
        return hook('AddNode', (resolve) => {
            const id = nextId.value++
            const node = createNode(id, x, y)
            nodes.value = {
                ...nodes.value,
                [id]: node
            }
            selectNode(id)
            return resolve(node);
        }, [x, y])
    }

    const removeNode = (id) => {
        return hook('RemoveNode', (resolve) => {
            delete nodes[id]
            resolve(id)
        }, [id])
    }

    const linkNodes = (parent, child) => {
        return hook('AddLink', (resolve) => {
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
            return resolve(edge)
        }, [parent, child])
    }

    const removeLink = (id) => {
        return hook('RemoveLink', (resolve) => {
            delete edges.value[id]
            resolve(id)
        }, [id])
    }

    return {
        nodesRef: nodes,
        get nodes () {
            return nodes.value
        },
        edgesRef: edges,
        get edges () {
            return edges.value
        },
        selectedNodeRef: selectedNode,
        get selectedNode () {
            return selectedNode.value
        },
        selectedEdgeRef: selectedEdge,
        get selectedEdge () {
            return selectedEdge.value
        },
        addNode,
        selectNode,
        selectEdge,
        linkNodes,
        nodeModel,
        edgeModel,
    }
}
