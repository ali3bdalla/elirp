<template>
    <div>
        <data-grid-frame :url="route('api.users.index')">
            <template v-slot:title>hello</template>
            <template v-slot:rows>
                <data-grid-column label="id" width="60">
                    <template v-slot:default="{ item }">
                        {{ item.id }}
                    </template>
                </data-grid-column>
                <data-grid-column label="Name">
                    <template v-slot:default="{ item }">
                        <div class="flex items-center justify-left gap-2">
                            <el-avatar
                                shape="circle"
                                size="small"
                                :src="item.profile_photo_url"
                                :alt="item.name"
                            ></el-avatar>
                            {{ item.name }}
                        </div>
                    </template>
                </data-grid-column>
                <data-grid-column label="E-mail Address">
                    <template v-slot:default="{ item }">
                        {{ item.email }}
                    </template>
                </data-grid-column>

                <data-grid-column label="Created At">
                    <template v-slot:default="{ item }">
                        {{ item.created_at }}
                    </template>
                </data-grid-column>
                <data-grid-column label="Created At">
                    <template v-slot:default="{ item }">
                        <el-dropdown>
                            <primary-button>
                                Dropdown List<i
                                    class="el-icon-arrow-down el-icon--right"
                                ></i>
                            </primary-button>
                            <template #dropdown>
                                <el-dropdown-menu>
                                    <el-dropdown-item
                                        >Action 1</el-dropdown-item
                                    >
                                    <el-dropdown-item
                                        >Action 2</el-dropdown-item
                                    >
                                    <el-dropdown-item
                                        >Action 3</el-dropdown-item
                                    >
                                    <el-dropdown-item
                                        >Action 4</el-dropdown-item
                                    >
                                    <el-dropdown-item
                                        >Action 5</el-dropdown-item
                                    >
                                </el-dropdown-menu>
                            </template>
                        </el-dropdown>
                    </template>
                </data-grid-column>
            </template>
        </data-grid-frame>
    </div>
</template>

<script>
import UserForm from "./UserForm";
import DataGridFrame from "../Frame/DataGridFrame";
import DataGridColumn from "../Frame/DataGridColumn";
import PrimaryButton from "../Button/PrimaryButton.vue";
export default {
    name: "UserTable",
    components: { DataGridColumn, PrimaryButton, DataGridFrame, UserForm },
};
</script>
