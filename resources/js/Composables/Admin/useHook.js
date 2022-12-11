import { isRef, onMounted, onUnmounted, reactive, ref, toRef, unref } from 'vue';

const hooks = ref({});

const nextId = ref(1);

export const useHook = (namespace, settings) => {

    const createNamespace = (namespace) => {
        hooks.value = {
            ...hooks.value,
            [namespace]: {}
        }
    }

    const deleteNamespace = (namespace) => {
        delete hooks.value?.[namespace]
    }

    const createEvent = (eventName) => {
        hooks.value[namespace] = {
            ...hooks.value[namespace],
            [eventName]: []
        }
    }

    const deleteEvent = (eventName) => {
        delete hooks.value?.[namespace]?.[eventName]
    }

    const addCallbackObject = (eventName, callbackObject) => {
        if (!hooks.value[namespace]?.[eventName]) {
            createEvent(eventName)
        }
        hooks.value[namespace][eventName] = {
            ...hooks.value[namespace][eventName],
            [callbackObject.id]: callbackObject
        }
    }

    const removeCallbackObject = (eventName, callbackObject) => {
        delete hooks.value[namespace][eventName][callbackObject.id]
    }

    const getCallbacks = (eventName) => {
        return Object.values(hooks.value[namespace][eventName] ?? {})
    }

    const createCallbackObject = (callback) => {
        return {
            id: nextId.value++,
            method: callback,
        }
    }

    const saveExistingHooks = (settings) => {
        for (let key in settings) {
            let value = settings[key]
            if (typeof value === 'function') {
                addCallbackObject(
                    key,
                    createCallbackObject(value)
                );
            }
        }
    }

    const invoke = (eventName, ...args) => {
        let callbacks = getCallbacks(eventName);
        callbacks.forEach(callback => {
            let result = callback.method(...args)
            if (result === false) return;
        })
    }

    const hook = (name, callback, deps) => {
        if (invoke(`onBefore${name}`, ...deps)) return;
        const resolve = (newDeps) => invoke(`onAfter${name}`, ...newDeps)
        const reject = (newDeps) => invoke(`onError${name}`, ...newDeps)
        callback(resolve, reject)
    }

    onMounted(() => {
        createNamespace(namespace)
        saveExistingHooks(settings)
    })

    onUnmounted(() => {
        deleteNamespace(namespace)
    })

    return {
        hook
    }
}
