import { createReduxStore, register } from '@wordpress/data';
import apiFetch from '@wordpress/api-fetch';

const DEFAULT_STATE = {
    options: {}
};

const SET_OPTIONS = 'SET_OPTIONS';

const store = createReduxStore('vk-option-text/options', {
	reducer(state = DEFAULT_STATE, action) {
		switch (action.type) {
			case SET_OPTIONS:
                return {
                    ...state,
                    options: action.value
                }
        }
        return state;
    },

    actions: {
        setOptions(values) {
			return {
				type: SET_OPTIONS,
				value: values,
			};            
        },
        updateOptions(options) {
            return async ({ dispatch }) => {
                await apiFetch({
                    path: 'vk-option-text/v2/settings',
                    method: 'POST',
                    data: options

                });
                dispatch.setOptions(options);
            }
        },        
    },

    selectors: {
        getOptions(state) {
            return state.options;
        },
    },
    resolvers: {
        getOptions() {
            return async ({ dispatch }) => {
                try {
                    const options = await apiFetch({
                        path: 'vk-option-text/v2/settings',
                        method: 'GET'
                    });
                    dispatch.setOptions(options);
                } catch (error) {
                    
                }
            }
        }       
    }

});

register(store);