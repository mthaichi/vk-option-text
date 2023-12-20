import { useState, useEffect } from '@wordpress/element';
import { useSelect } from '@wordpress/data';

const useOptionsData = () => {
    const [options, setOptions] = useState({});
    const [isLoading, setIsLoading] = useState(true);

    const storeData = useSelect((select) => {
        const store = select('vk-option-text/options');
        return {
            options: store.getOptions(),
            isLoading: store.isResolving('getOptions'),
        };
    });

    useEffect(() => {
        if (!storeData.isLoading && storeData.options && Object.keys(options).length === 0) {
            setOptions(storeData.options);
            setIsLoading(false);
        }
    }, [storeData]);

    return { options, setOptions, isLoading };
};

export default useOptionsData;
