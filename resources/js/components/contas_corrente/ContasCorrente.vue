<template>
<div id="ContasCorrente">
    <EditableTable :items="items" :fields="fields"></EditableTable>
</div>
</template>

<script>
import EditableTable from '../../Components/EditableTable.vue'
export default {
  name: "ContasCorrente",
  components: {
    EditableTable
  },
  data() {
    return {
      fields: [
        { key: "name", label: "Name" },
        { key: "department", label: "Department" },
        { key: "age", label: "Age" },
        { key: "dateOfBirth", label: "Date Of Birth" },
        { key: "edit", label: "" }
      ],
       items: [
          { age: 40, name: 'Dickerson', department: 'Development', dateOfBirth: '1984-05-20' },
          { age: 21, name: 'Larsen', department: 'Marketing', dateOfBirth: '1984-05-20' },
          { age: 89, name: 'Geneva', department: 'HR', dateOfBirth: '1984-05-20' },
          { age: 38, name: 'Jami', department: 'Accounting', dateOfBirth: '1984-05-20' }
        ]
    };
  }
};
</script>

<style>
#ContasCorrente {
  text-align: center;
  margin: 60px;
}
thead, tbody, tfoot, tr, td, th {
  text-align: left;
  width: 100px;
  vertical-align: middle;
}
pre {
  text-align: left;
  color: #d63384 !important;
}
</style>