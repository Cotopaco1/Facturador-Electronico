import axios from "axios";
import { alertError } from "./AlertService";

export async function getRequest(url){

    try {

        const response = await axios.get(url);

        return response.data;

    } catch (error) {
        alertError('Status:' + error.response.status, error.response.data.message);
        return Promise.reject(error);
    }
    
}

export async function postRequest(url, data){

    try {

        const response = await axios.post(url, data);

        return response.data;

    } catch (error) {
        
        alertError('Status:' + error.response.status, error.response.data.message);
        return Promise.reject(error);
    }
    
}

