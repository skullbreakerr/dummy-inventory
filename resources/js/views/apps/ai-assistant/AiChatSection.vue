<template>
    <div>
        <h2>AI Chat Section</h2>
        <form @submit.prevent="handleSubmit">
            <div>
                <label for="prompt">Enter your prompt:</label>
                <input type="text" id="prompt" v-model="userPrompt" required />
            </div>
            <div>
                <label for="file">Upload a file:</label>
                <input type="file" id="file" @change="handleFileUpload" />
            </div>
            <button type="submit">Submit</button>
        </form>
        <div v-if="aiResponse">
            <h3>AI Response:</h3>
            <div v-html="formattedAiResponse"></div>
        </div>
    </div>
</template>

<script>
import { ref, computed, onMounted } from 'vue';
import ApiService from "@/core/services/ApiService";
import { useInventoryStore } from '@/stores/inventory';
export default {
    name: 'AiChatSection',
    setup() {
        const inventoryStore = useInventoryStore();
        const userPrompt = ref('');
        const aiResponse = ref('');
        const fileContent = ref(null);

        const handleFileUpload = (event) => {
            const file = event.target.files[0];
            const reader = new FileReader();
            reader.onload = (e) => {
                fileContent.value = e.target.result;
            };
            reader.readAsText(file);
        };
        onMounted(async () => {
            if (inventoryStore.inventoryData.length === 0) {
                await inventoryStore.fetchInventoryData();
            }
        });
        const summarizeInventoryData = () => {
            const inventoryData = inventoryStore.inventoryData;
            console.log("inventoryAI: ", inventoryData)
            return inventoryData.map(record => {
                return `Item: ${record.item.name}, Quantity: ${record.item.qty}, Unit Price: ${record.item.unit_price}, Total Value: ${record.item.total_value}, Stock Status: ${record.status}`;
            }).join('\n');
        };

        const handleSubmit = async () => {
            try {
                let prompt = userPrompt.value;
                if (fileContent.value) {
                    prompt += `\n\nFile Content:\n${fileContent.value}`;
                }
                const inventorySummary = summarizeInventoryData();
                prompt += `\n\nInventory Data:\n${inventorySummary}`;

                const requestData = {
                    'model': 'nvidia/llama-3.1-nemotron-70b-instruct',
                    'max_tokens': 1024,
                    'stream': false,
                    'temperature': 0.5,
                    'top_p': 1,
                    'frequency_penalty': 0,
                    'presence_penalty': 0,
                    'seed': 0,
                    'messages': [
                        {
                            'role': 'system',
                            'content': `you are erp Ai. which will answer all the question of the user by referring the given users companies data`,
                        },
                        {
                            'role': 'user',
                            'content': prompt,
                        },
                    ],
                };
                const response = await ApiService.post('api/ask-question', requestData);

                aiResponse.value = response.data.data; // Ensure this is a string
            } catch (error) {
                console.error('Error getting AI response:', error);
                aiResponse.value = 'Error getting AI response';
            }
        };

        const formattedAiResponse = computed(() => {
            if (!aiResponse.value) return '';
            const response = aiResponse.value;
            if (typeof response !== 'string') {
                return 'Unexpected response format';
            }
            return response
                .replace(/\n\n/g, '<br><br>')
                .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
                .replace(/\t\*/g, '<li>')
                .replace(/\n\t/g, '</li><li>')
                .replace(/\n/g, '<br>')
                .replace(/<\/li><li><br>/g, '</li><li>')
                .replace(/<\/li><li>$/g, '</li>')
                .replace(/<br><br><li>/g, '<ul><li>')
                .replace(/<\/li><br><br>/g, '</li></ul><br><br>')
                .replace(/<br><br><tr>/g, '<table><tr>')
                .replace(/<\/tr><br><br>/g, '</tr></table><br><br>');

        });

        return {
            userPrompt,
            aiResponse,
            handleFileUpload,
            handleSubmit,
            formattedAiResponse,
        };
    },
};
</script>

<style scoped>
/* Add any scoped styles here */
h3 {
    color: #333;
    margin-bottom: 10px;
}

div[v-html] {
    background-color: #f9f9f9;
    padding: 15px;
    border-radius: 5px;
    border: 1px solid #ddd;
    white-space: pre-wrap;
    /* Preserve whitespace */
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

th,
td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

th {
    background-color: #f2f2f2;
}

ul {
    padding-left: 20px;
}

li {
    margin-bottom: 5px;
}
</style>