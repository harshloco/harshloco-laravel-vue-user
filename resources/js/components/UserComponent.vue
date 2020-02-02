<template>
  <v-app>
    <v-content>
      <v-container class="my-5">
        <v-card max-width="90%" class="mx-auto">
          <v-card-title>
            Users
            <v-spacer></v-spacer>
            <v-dialog v-model="dialog" max-width="80%">
              <v-card>
                <v-card-title>
                  <span class="headline">{{ formTitle }}</span>
                </v-card-title>

                <v-card-text>
                  <v-container grid-list-md>
                    <v-layout wrap>
                      <v-flex xs12>
                        <h3>Roles</h3>
                        <v-select
                          v-model="editedItem.role"
                          :items="allRoles"
                          label="Roles"
                          item-text="name"
                          return-object
                          chips
                        ></v-select>
                      </v-flex>
                    </v-layout>
                  </v-container>
                </v-card-text>

                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" test @click="close">Cancel</v-btn>
                  <v-btn color="blue darken-1" text @click="save">Save</v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
            <v-text-field v-model="search" label="Search" single-line hide-details></v-text-field>
          </v-card-title>
          <v-data-table
            :headers="headers"
            :items="tableData"
            :search="search"
            :items-per-page="5"
            multi-sort
            class="elevation-1"
          >
            <template v-slot:item.authorized="{ item }">
              <v-sheet
                class="d-flex m-2 justify-center white--text"
                width="150"
                height="20"
                elevation="1"
                color="#7F004F"
                tile="authorized"
              >{{ item.authorized }}</v-sheet>
            </template>
            <template v-slot:item.user_type="{ item }">
              <v-sheet
                class="d-flex m-2 justify-center white--text"
                width="150"
                height="20"
                elevation="1"
                color="#7F004F"
                tile="user_type"
              >{{ item.user_type }}</v-sheet>
            </template>
          </v-data-table>
        </v-card>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
export default {
  data: () => ({
    search: "",
    dialog: false,
    headers: [
      { text: "Full Name", value: "name" },
      { text: "Email", value: "email" },
      { text: "Last Logged In", value: "last_logged_in" },
      { text: "Authorized", value: "authorized" },
      { text: "User Type", value: "user_type" }
    ],
    tableData: [],
    editedIndex: -1,
    allRoles: [],
    editedItem: {
      id: "",
      name: "",
      email: "",
      last_logged_in: "",
      authorized: "",
      user_type: "",
      role: []
    },
    defaultItem: {
      id: "",
      name: "",
      email: "",
      last_logged_in: "",
      authorized: "",
      user_type: "",
      role: []
    }
  }),
  computed: {
    formTitle() {
      return "Edit User Role";
    }
  },
  watch: {
    dialog(val) {
      val || this.close();
    }
  },
  created() {
    this.initialize();
  },
  methods: {
    initialize() {
      axios.get("/api/users").then(response => {
        this.tableData = response.data.data;
      });

      axios
        .get("/userTypes")
        .then(response => (this.allRoles = response.data.data));
    },
    editItem(item) {
      //  alert("item is " + item + " " + this.tableData.indexOf(item));
      this.editedIndex = this.tableData.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    close() {
      this.dialog = false;
      setTimeout(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      }, 300);
    },
    save() {
      if (this.editedIndex > -1) {
        Object.assign(this.tableData[this.editedIndex], this.editedItem);

        axios
          .get(
            "/userUpdate/" + this.editedItem.id + "/" + this.editedItem.role.id
          )
          .then(response => {
            if (response.data == "success") {
              this.tableData[
                this.editedIndex
              ].user_type = this.editedItem.role.name.toUpperCase();
            }
          });
      }
      this.close();
    },
    getColor(user_type) {
      if (user_type === "UNAUTHORIZED") return "red";
      else return "green";
    }
  }
};
</script>
